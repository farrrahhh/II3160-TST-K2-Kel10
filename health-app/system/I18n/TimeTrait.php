<?php

declare(strict_types=1);

namespace CodeIgniter\I18n;

use CodeIgniter\I18n\Exceptions\I18nException;
use DateInterval;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
use DateTimeZone;
use Exception;
use IntlCalendar;
use IntlDateFormatter;
use Locale;
use ReturnTypeWillChange;

/**
 * TimeTrait provides functionalities for Time and TimeLegacy classes.
 * Handles creation and formatting of time objects, considering localization.
 */
trait TimeTrait
{
    protected DateTimeZone $timezone;
    protected string $locale;
    protected string $toStringFormat = 'yyyy-MM-dd HH:mm:ss';
    protected static string $relativePattern = '/this|next|last|tomorrow|yesterday|midnight|today|[+-]|first|last|ago/i';
    protected static ?DateTimeInterface $testNow = null;

    public function __construct(?string $time = null, $timezone = null, ?string $locale = null)
    {
        $this->locale = $locale ?? Locale::getDefault();
        $timezone = $timezone ?: date_default_timezone_get();
        $this->timezone = $timezone instanceof DateTimeZone ? $timezone : new DateTimeZone($timezone);

        if (static::$testNow instanceof self && $time === null) {
            $timezone = $timezone ?: static::$testNow->getTimezone();
            $time = static::$testNow->format('Y-m-d H:i:s');
        }

        $time = $time ?: 'now';
        parent::__construct($time, $this->timezone);
    }

    public static function now($timezone = null, ?string $locale = null): self
    {
        return new self(null, $timezone, $locale);
    }

    public static function parse(string $datetime, $timezone = null, ?string $locale = null): self
    {
        return new self($datetime, $timezone, $locale);
    }

    // ... (additional methods) ...

    #[ReturnTypeWillChange]
    public function setTimezone($timezone): self
    {
        $timezone = new DateTimeZone($timezone);
        return new self($this->format('Y-m-d H:i:s'), $timezone, $this->locale);
    }

    // ... (additional methods) ...

    public function __toString(): string
    {
        return $this->format('Y-m-d H:i:s');
    }

    // Unserialization adjustment
    public function __wakeup(): void
    {
        $this->timezone = new DateTimeZone($this->timezone->getName());
    }
}