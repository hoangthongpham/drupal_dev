<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: opentelemetry/proto/logs/v1/logs.proto

namespace Opentelemetry\Proto\Logs\V1;

use Google\Protobuf\Internal\GPBType;
use Google\Protobuf\Internal\RepeatedField;
use Google\Protobuf\Internal\GPBUtil;

/**
 * A log record according to OpenTelemetry Log Data Model:
 * https://github.com/open-telemetry/oteps/blob/main/text/logs/0097-log-data-model.md
 *
 * Generated from protobuf message <code>opentelemetry.proto.logs.v1.LogRecord</code>
 */
class LogRecord extends \Google\Protobuf\Internal\Message
{
    /**
     * time_unix_nano is the time when the event occurred.
     * Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January 1970.
     * Value of 0 indicates unknown or missing timestamp.
     *
     * Generated from protobuf field <code>fixed64 time_unix_nano = 1;</code>
     */
    protected $time_unix_nano = 0;
    /**
     * Time when the event was observed by the collection system.
     * For events that originate in OpenTelemetry (e.g. using OpenTelemetry Logging SDK)
     * this timestamp is typically set at the generation time and is equal to Timestamp.
     * For events originating externally and collected by OpenTelemetry (e.g. using
     * Collector) this is the time when OpenTelemetry's code observed the event measured
     * by the clock of the OpenTelemetry code. This field MUST be set once the event is
     * observed by OpenTelemetry.
     * For converting OpenTelemetry log data to formats that support only one timestamp or
     * when receiving OpenTelemetry log data by recipients that support only one timestamp
     * internally the following logic is recommended:
     *   - Use time_unix_nano if it is present, otherwise use observed_time_unix_nano.
     * Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January 1970.
     * Value of 0 indicates unknown or missing timestamp.
     *
     * Generated from protobuf field <code>fixed64 observed_time_unix_nano = 11;</code>
     */
    protected $observed_time_unix_nano = 0;
    /**
     * Numerical value of the severity, normalized to values described in Log Data Model.
     * [Optional].
     *
     * Generated from protobuf field <code>.opentelemetry.proto.logs.v1.SeverityNumber severity_number = 2;</code>
     */
    protected $severity_number = 0;
    /**
     * The severity text (also known as log level). The original string representation as
     * it is known at the source. [Optional].
     *
     * Generated from protobuf field <code>string severity_text = 3;</code>
     */
    protected $severity_text = '';
    /**
     * A value containing the body of the log record. Can be for example a human-readable
     * string message (including multi-line) describing the event in a free form or it can
     * be a structured data composed of arrays and maps of other values. [Optional].
     *
     * Generated from protobuf field <code>.opentelemetry.proto.common.v1.AnyValue body = 5;</code>
     */
    protected $body = null;
    /**
     * Additional attributes that describe the specific event occurrence. [Optional].
     * Attribute keys MUST be unique (it is not allowed to have more than one
     * attribute with the same key).
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.common.v1.KeyValue attributes = 6;</code>
     */
    private $attributes;
    /**
     * Generated from protobuf field <code>uint32 dropped_attributes_count = 7;</code>
     */
    protected $dropped_attributes_count = 0;
    /**
     * Flags, a bit field. 8 least significant bits are the trace flags as
     * defined in W3C Trace Context specification. 24 most significant bits are reserved
     * and must be set to 0. Readers must not assume that 24 most significant bits
     * will be zero and must correctly mask the bits when reading 8-bit trace flag (use
     * flags & LOG_RECORD_FLAGS_TRACE_FLAGS_MASK). [Optional].
     *
     * Generated from protobuf field <code>fixed32 flags = 8;</code>
     */
    protected $flags = 0;
    /**
     * A unique identifier for a trace. All logs from the same trace share
     * the same `trace_id`. The ID is a 16-byte array. An ID with all zeroes OR
     * of length other than 16 bytes is considered invalid (empty string in OTLP/JSON
     * is zero-length and thus is also invalid).
     * This field is optional.
     * The receivers SHOULD assume that the log record is not associated with a
     * trace if any of the following is true:
     *   - the field is not present,
     *   - the field contains an invalid value.
     *
     * Generated from protobuf field <code>bytes trace_id = 9;</code>
     */
    protected $trace_id = '';
    /**
     * A unique identifier for a span within a trace, assigned when the span
     * is created. The ID is an 8-byte array. An ID with all zeroes OR of length
     * other than 8 bytes is considered invalid (empty string in OTLP/JSON
     * is zero-length and thus is also invalid).
     * This field is optional. If the sender specifies a valid span_id then it SHOULD also
     * specify a valid trace_id.
     * The receivers SHOULD assume that the log record is not associated with a
     * span if any of the following is true:
     *   - the field is not present,
     *   - the field contains an invalid value.
     *
     * Generated from protobuf field <code>bytes span_id = 10;</code>
     */
    protected $span_id = '';
    /**
     * A unique identifier of event category/type.
     * All events with the same event_name are expected to conform to the same
     * schema for both their attributes and their body.
     * Recommended to be fully qualified and short (no longer than 256 characters).
     * Presence of event_name on the log record identifies this record
     * as an event.
     * [Optional].
     * Status: [Development]
     *
     * Generated from protobuf field <code>string event_name = 12;</code>
     */
    protected $event_name = '';

    /**
     * Constructor.
     *
     * @param array $data {
     *     Optional. Data for populating the Message object.
     *
     *     @type int|string $time_unix_nano
     *           time_unix_nano is the time when the event occurred.
     *           Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January 1970.
     *           Value of 0 indicates unknown or missing timestamp.
     *     @type int|string $observed_time_unix_nano
     *           Time when the event was observed by the collection system.
     *           For events that originate in OpenTelemetry (e.g. using OpenTelemetry Logging SDK)
     *           this timestamp is typically set at the generation time and is equal to Timestamp.
     *           For events originating externally and collected by OpenTelemetry (e.g. using
     *           Collector) this is the time when OpenTelemetry's code observed the event measured
     *           by the clock of the OpenTelemetry code. This field MUST be set once the event is
     *           observed by OpenTelemetry.
     *           For converting OpenTelemetry log data to formats that support only one timestamp or
     *           when receiving OpenTelemetry log data by recipients that support only one timestamp
     *           internally the following logic is recommended:
     *             - Use time_unix_nano if it is present, otherwise use observed_time_unix_nano.
     *           Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January 1970.
     *           Value of 0 indicates unknown or missing timestamp.
     *     @type int $severity_number
     *           Numerical value of the severity, normalized to values described in Log Data Model.
     *           [Optional].
     *     @type string $severity_text
     *           The severity text (also known as log level). The original string representation as
     *           it is known at the source. [Optional].
     *     @type \Opentelemetry\Proto\Common\V1\AnyValue $body
     *           A value containing the body of the log record. Can be for example a human-readable
     *           string message (including multi-line) describing the event in a free form or it can
     *           be a structured data composed of arrays and maps of other values. [Optional].
     *     @type \Opentelemetry\Proto\Common\V1\KeyValue[]|\Google\Protobuf\Internal\RepeatedField $attributes
     *           Additional attributes that describe the specific event occurrence. [Optional].
     *           Attribute keys MUST be unique (it is not allowed to have more than one
     *           attribute with the same key).
     *     @type int $dropped_attributes_count
     *     @type int $flags
     *           Flags, a bit field. 8 least significant bits are the trace flags as
     *           defined in W3C Trace Context specification. 24 most significant bits are reserved
     *           and must be set to 0. Readers must not assume that 24 most significant bits
     *           will be zero and must correctly mask the bits when reading 8-bit trace flag (use
     *           flags & LOG_RECORD_FLAGS_TRACE_FLAGS_MASK). [Optional].
     *     @type string $trace_id
     *           A unique identifier for a trace. All logs from the same trace share
     *           the same `trace_id`. The ID is a 16-byte array. An ID with all zeroes OR
     *           of length other than 16 bytes is considered invalid (empty string in OTLP/JSON
     *           is zero-length and thus is also invalid).
     *           This field is optional.
     *           The receivers SHOULD assume that the log record is not associated with a
     *           trace if any of the following is true:
     *             - the field is not present,
     *             - the field contains an invalid value.
     *     @type string $span_id
     *           A unique identifier for a span within a trace, assigned when the span
     *           is created. The ID is an 8-byte array. An ID with all zeroes OR of length
     *           other than 8 bytes is considered invalid (empty string in OTLP/JSON
     *           is zero-length and thus is also invalid).
     *           This field is optional. If the sender specifies a valid span_id then it SHOULD also
     *           specify a valid trace_id.
     *           The receivers SHOULD assume that the log record is not associated with a
     *           span if any of the following is true:
     *             - the field is not present,
     *             - the field contains an invalid value.
     *     @type string $event_name
     *           A unique identifier of event category/type.
     *           All events with the same event_name are expected to conform to the same
     *           schema for both their attributes and their body.
     *           Recommended to be fully qualified and short (no longer than 256 characters).
     *           Presence of event_name on the log record identifies this record
     *           as an event.
     *           [Optional].
     *           Status: [Development]
     * }
     */
    public function __construct($data = NULL) {
        \GPBMetadata\Opentelemetry\Proto\Logs\V1\Logs::initOnce();
        parent::__construct($data);
    }

    /**
     * time_unix_nano is the time when the event occurred.
     * Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January 1970.
     * Value of 0 indicates unknown or missing timestamp.
     *
     * Generated from protobuf field <code>fixed64 time_unix_nano = 1;</code>
     * @return int|string
     */
    public function getTimeUnixNano()
    {
        return $this->time_unix_nano;
    }

    /**
     * time_unix_nano is the time when the event occurred.
     * Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January 1970.
     * Value of 0 indicates unknown or missing timestamp.
     *
     * Generated from protobuf field <code>fixed64 time_unix_nano = 1;</code>
     * @param int|string $var
     * @return $this
     */
    public function setTimeUnixNano($var)
    {
        GPBUtil::checkUint64($var);
        $this->time_unix_nano = $var;

        return $this;
    }

    /**
     * Time when the event was observed by the collection system.
     * For events that originate in OpenTelemetry (e.g. using OpenTelemetry Logging SDK)
     * this timestamp is typically set at the generation time and is equal to Timestamp.
     * For events originating externally and collected by OpenTelemetry (e.g. using
     * Collector) this is the time when OpenTelemetry's code observed the event measured
     * by the clock of the OpenTelemetry code. This field MUST be set once the event is
     * observed by OpenTelemetry.
     * For converting OpenTelemetry log data to formats that support only one timestamp or
     * when receiving OpenTelemetry log data by recipients that support only one timestamp
     * internally the following logic is recommended:
     *   - Use time_unix_nano if it is present, otherwise use observed_time_unix_nano.
     * Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January 1970.
     * Value of 0 indicates unknown or missing timestamp.
     *
     * Generated from protobuf field <code>fixed64 observed_time_unix_nano = 11;</code>
     * @return int|string
     */
    public function getObservedTimeUnixNano()
    {
        return $this->observed_time_unix_nano;
    }

    /**
     * Time when the event was observed by the collection system.
     * For events that originate in OpenTelemetry (e.g. using OpenTelemetry Logging SDK)
     * this timestamp is typically set at the generation time and is equal to Timestamp.
     * For events originating externally and collected by OpenTelemetry (e.g. using
     * Collector) this is the time when OpenTelemetry's code observed the event measured
     * by the clock of the OpenTelemetry code. This field MUST be set once the event is
     * observed by OpenTelemetry.
     * For converting OpenTelemetry log data to formats that support only one timestamp or
     * when receiving OpenTelemetry log data by recipients that support only one timestamp
     * internally the following logic is recommended:
     *   - Use time_unix_nano if it is present, otherwise use observed_time_unix_nano.
     * Value is UNIX Epoch time in nanoseconds since 00:00:00 UTC on 1 January 1970.
     * Value of 0 indicates unknown or missing timestamp.
     *
     * Generated from protobuf field <code>fixed64 observed_time_unix_nano = 11;</code>
     * @param int|string $var
     * @return $this
     */
    public function setObservedTimeUnixNano($var)
    {
        GPBUtil::checkUint64($var);
        $this->observed_time_unix_nano = $var;

        return $this;
    }

    /**
     * Numerical value of the severity, normalized to values described in Log Data Model.
     * [Optional].
     *
     * Generated from protobuf field <code>.opentelemetry.proto.logs.v1.SeverityNumber severity_number = 2;</code>
     * @return int
     */
    public function getSeverityNumber()
    {
        return $this->severity_number;
    }

    /**
     * Numerical value of the severity, normalized to values described in Log Data Model.
     * [Optional].
     *
     * Generated from protobuf field <code>.opentelemetry.proto.logs.v1.SeverityNumber severity_number = 2;</code>
     * @param int $var
     * @return $this
     */
    public function setSeverityNumber($var)
    {
        GPBUtil::checkEnum($var, \Opentelemetry\Proto\Logs\V1\SeverityNumber::class);
        $this->severity_number = $var;

        return $this;
    }

    /**
     * The severity text (also known as log level). The original string representation as
     * it is known at the source. [Optional].
     *
     * Generated from protobuf field <code>string severity_text = 3;</code>
     * @return string
     */
    public function getSeverityText()
    {
        return $this->severity_text;
    }

    /**
     * The severity text (also known as log level). The original string representation as
     * it is known at the source. [Optional].
     *
     * Generated from protobuf field <code>string severity_text = 3;</code>
     * @param string $var
     * @return $this
     */
    public function setSeverityText($var)
    {
        GPBUtil::checkString($var, True);
        $this->severity_text = $var;

        return $this;
    }

    /**
     * A value containing the body of the log record. Can be for example a human-readable
     * string message (including multi-line) describing the event in a free form or it can
     * be a structured data composed of arrays and maps of other values. [Optional].
     *
     * Generated from protobuf field <code>.opentelemetry.proto.common.v1.AnyValue body = 5;</code>
     * @return \Opentelemetry\Proto\Common\V1\AnyValue|null
     */
    public function getBody()
    {
        return $this->body;
    }

    public function hasBody()
    {
        return isset($this->body);
    }

    public function clearBody()
    {
        unset($this->body);
    }

    /**
     * A value containing the body of the log record. Can be for example a human-readable
     * string message (including multi-line) describing the event in a free form or it can
     * be a structured data composed of arrays and maps of other values. [Optional].
     *
     * Generated from protobuf field <code>.opentelemetry.proto.common.v1.AnyValue body = 5;</code>
     * @param \Opentelemetry\Proto\Common\V1\AnyValue $var
     * @return $this
     */
    public function setBody($var)
    {
        GPBUtil::checkMessage($var, \Opentelemetry\Proto\Common\V1\AnyValue::class);
        $this->body = $var;

        return $this;
    }

    /**
     * Additional attributes that describe the specific event occurrence. [Optional].
     * Attribute keys MUST be unique (it is not allowed to have more than one
     * attribute with the same key).
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.common.v1.KeyValue attributes = 6;</code>
     * @return \Google\Protobuf\Internal\RepeatedField
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Additional attributes that describe the specific event occurrence. [Optional].
     * Attribute keys MUST be unique (it is not allowed to have more than one
     * attribute with the same key).
     *
     * Generated from protobuf field <code>repeated .opentelemetry.proto.common.v1.KeyValue attributes = 6;</code>
     * @param \Opentelemetry\Proto\Common\V1\KeyValue[]|\Google\Protobuf\Internal\RepeatedField $var
     * @return $this
     */
    public function setAttributes($var)
    {
        $arr = GPBUtil::checkRepeatedField($var, \Google\Protobuf\Internal\GPBType::MESSAGE, \Opentelemetry\Proto\Common\V1\KeyValue::class);
        $this->attributes = $arr;

        return $this;
    }

    /**
     * Generated from protobuf field <code>uint32 dropped_attributes_count = 7;</code>
     * @return int
     */
    public function getDroppedAttributesCount()
    {
        return $this->dropped_attributes_count;
    }

    /**
     * Generated from protobuf field <code>uint32 dropped_attributes_count = 7;</code>
     * @param int $var
     * @return $this
     */
    public function setDroppedAttributesCount($var)
    {
        GPBUtil::checkUint32($var);
        $this->dropped_attributes_count = $var;

        return $this;
    }

    /**
     * Flags, a bit field. 8 least significant bits are the trace flags as
     * defined in W3C Trace Context specification. 24 most significant bits are reserved
     * and must be set to 0. Readers must not assume that 24 most significant bits
     * will be zero and must correctly mask the bits when reading 8-bit trace flag (use
     * flags & LOG_RECORD_FLAGS_TRACE_FLAGS_MASK). [Optional].
     *
     * Generated from protobuf field <code>fixed32 flags = 8;</code>
     * @return int
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * Flags, a bit field. 8 least significant bits are the trace flags as
     * defined in W3C Trace Context specification. 24 most significant bits are reserved
     * and must be set to 0. Readers must not assume that 24 most significant bits
     * will be zero and must correctly mask the bits when reading 8-bit trace flag (use
     * flags & LOG_RECORD_FLAGS_TRACE_FLAGS_MASK). [Optional].
     *
     * Generated from protobuf field <code>fixed32 flags = 8;</code>
     * @param int $var
     * @return $this
     */
    public function setFlags($var)
    {
        GPBUtil::checkUint32($var);
        $this->flags = $var;

        return $this;
    }

    /**
     * A unique identifier for a trace. All logs from the same trace share
     * the same `trace_id`. The ID is a 16-byte array. An ID with all zeroes OR
     * of length other than 16 bytes is considered invalid (empty string in OTLP/JSON
     * is zero-length and thus is also invalid).
     * This field is optional.
     * The receivers SHOULD assume that the log record is not associated with a
     * trace if any of the following is true:
     *   - the field is not present,
     *   - the field contains an invalid value.
     *
     * Generated from protobuf field <code>bytes trace_id = 9;</code>
     * @return string
     */
    public function getTraceId()
    {
        return $this->trace_id;
    }

    /**
     * A unique identifier for a trace. All logs from the same trace share
     * the same `trace_id`. The ID is a 16-byte array. An ID with all zeroes OR
     * of length other than 16 bytes is considered invalid (empty string in OTLP/JSON
     * is zero-length and thus is also invalid).
     * This field is optional.
     * The receivers SHOULD assume that the log record is not associated with a
     * trace if any of the following is true:
     *   - the field is not present,
     *   - the field contains an invalid value.
     *
     * Generated from protobuf field <code>bytes trace_id = 9;</code>
     * @param string $var
     * @return $this
     */
    public function setTraceId($var)
    {
        GPBUtil::checkString($var, False);
        $this->trace_id = $var;

        return $this;
    }

    /**
     * A unique identifier for a span within a trace, assigned when the span
     * is created. The ID is an 8-byte array. An ID with all zeroes OR of length
     * other than 8 bytes is considered invalid (empty string in OTLP/JSON
     * is zero-length and thus is also invalid).
     * This field is optional. If the sender specifies a valid span_id then it SHOULD also
     * specify a valid trace_id.
     * The receivers SHOULD assume that the log record is not associated with a
     * span if any of the following is true:
     *   - the field is not present,
     *   - the field contains an invalid value.
     *
     * Generated from protobuf field <code>bytes span_id = 10;</code>
     * @return string
     */
    public function getSpanId()
    {
        return $this->span_id;
    }

    /**
     * A unique identifier for a span within a trace, assigned when the span
     * is created. The ID is an 8-byte array. An ID with all zeroes OR of length
     * other than 8 bytes is considered invalid (empty string in OTLP/JSON
     * is zero-length and thus is also invalid).
     * This field is optional. If the sender specifies a valid span_id then it SHOULD also
     * specify a valid trace_id.
     * The receivers SHOULD assume that the log record is not associated with a
     * span if any of the following is true:
     *   - the field is not present,
     *   - the field contains an invalid value.
     *
     * Generated from protobuf field <code>bytes span_id = 10;</code>
     * @param string $var
     * @return $this
     */
    public function setSpanId($var)
    {
        GPBUtil::checkString($var, False);
        $this->span_id = $var;

        return $this;
    }

    /**
     * A unique identifier of event category/type.
     * All events with the same event_name are expected to conform to the same
     * schema for both their attributes and their body.
     * Recommended to be fully qualified and short (no longer than 256 characters).
     * Presence of event_name on the log record identifies this record
     * as an event.
     * [Optional].
     * Status: [Development]
     *
     * Generated from protobuf field <code>string event_name = 12;</code>
     * @return string
     */
    public function getEventName()
    {
        return $this->event_name;
    }

    /**
     * A unique identifier of event category/type.
     * All events with the same event_name are expected to conform to the same
     * schema for both their attributes and their body.
     * Recommended to be fully qualified and short (no longer than 256 characters).
     * Presence of event_name on the log record identifies this record
     * as an event.
     * [Optional].
     * Status: [Development]
     *
     * Generated from protobuf field <code>string event_name = 12;</code>
     * @param string $var
     * @return $this
     */
    public function setEventName($var)
    {
        GPBUtil::checkString($var, True);
        $this->event_name = $var;

        return $this;
    }

}
