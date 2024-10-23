<?php

namespace Drupal\article\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Pager\PagerManagerInterface;
use Drupal\Core\Pager\PagerParametersInterface;
use Drupal\Core\Render\RendererInterface;
use Drupal\node\Entity\Node;
use Drupal\media\Entity\Media;
use Drupal\file\Entity\File;
use Drupal\Core\Link;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

class BlogController extends ControllerBase
{

    const LIMIT_ITEM = 5;

    /**
     * @return array
     * @throws \Exception
     */
    public function index()
    {
        $limit = self::LIMIT_ITEM;
        $pagerManager = \Drupal::service('pager.manager');
        $currentPage = \Drupal::service('pager.parameters')->findPage();

        $offset = $currentPage * $limit;

        $nodes = $this->getNodes($offset, $limit);

        // Create and apply the pager.
        $pagerManager->createPager($this->totalItem(), $limit);

        $renderer = \Drupal::service('renderer');
        $pagerElement = [
            'pager' => [
                '#type' => 'pager',
            ]
        ];

        return [
            'list' => [
                '#theme' => 'blogs',
                '#data' => [
                    'items' => $this->handleNodes($nodes),
                    'pager' => $renderer->render($pagerElement)
                ],
            ],
            '#cache' => [
                'max-age' => 0,  // Disable caching
            ],
        ];
    }

    /**
     * @param $offset
     * @param $limit
     * @return \Drupal\Core\Entity\EntityBase[]|\Drupal\Core\Entity\EntityInterface[]|Node[]
     */
    public function getNodes($offset, $limit)
    {
        $query = \Drupal::entityQuery('node')
            ->condition('type', 'recipe')
            ->condition('status', 1)
            ->accessCheck(TRUE)
            ->sort('created', 'DESC')
            ->range($offset, $limit);

        $nids = $query->execute();
        return Node::loadMultiple($nids);
    }

    public function totalItem()
    {
        return \Drupal::entityQuery('node')
            ->condition('type', 'recipe')
            ->condition('status', 1)
            ->accessCheck(TRUE)
            ->count()
            ->execute();
    }

    /**
     * @param $nodes
     * @return array|array[]
     */
    public function handleNodes($nodes)
    {
        return array_map(function ($node) {
            $media = Media::load($node->get('field_media_image')->target_id);

            $imageUrl = 'themes/mini_store/public/images/blog/1.jpg';
            if ($media && $media->hasField('field_media_image') && !$media->get('field_media_image')->isEmpty()) {
                $file = $media->get('field_media_image')->entity;
                if ($file instanceof File) {
                    $uri = $file->getFileUri();
                    $imageUrl = \Drupal::service('file_url_generator')->generateAbsoluteString($uri);
                }
            }

            return [
                'title' => $node->label(),
                'created' => date('d F Y', $node->getCreatedTime()),
                'author' => $node->getOwner()->getDisplayName(),
                'summary' => $node->get('field_summary')->value,
                'imageUrl' => $imageUrl,
                'detail' => Url::fromRoute('entity.node.canonical', ['node' => $node->id()]),
            ];
        }, $nodes);
    }
}
