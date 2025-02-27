<?php

declare(strict_types=1);

/*
 * This file is part of Ekino New Relic bundle.
 *
 * (c) Ekino - Thomas Rabaix <thomas.rabaix@ekino.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Ekino\NewRelicBundle\NewRelic;

class NewRelicInteractor implements NewRelicInteractorInterface
{
    public function setApplicationName(string $name, ?string $license = null, bool $xmit = false): bool
    {
        return newrelic_set_appname($name, $license, $xmit);
    }

    public function setTransactionName(string $name): bool
    {
        return newrelic_name_transaction($name);
    }

    public function ignoreTransaction(): void
    {
        newrelic_ignore_transaction();
    }

    public function addCustomEvent(string $name, array $attributes): void
    {
        newrelic_record_custom_event((string) $name, $attributes);
    }

    public function addCustomMetric(string $name, float $value): bool
    {
        return newrelic_custom_metric($name, $value);
    }

    public function addCustomParameter(string $name, $value): bool
    {
        return newrelic_add_custom_parameter((string) $name, $value);
    }

    public function getBrowserTimingHeader(bool $includeTags = true): string
    {
        return newrelic_get_browser_timing_header($includeTags);
    }

    public function getBrowserTimingFooter(bool $includeTags = true): string
    {
        return newrelic_get_browser_timing_footer($includeTags);
    }

    public function disableAutoRUM(): ?bool
    {
        return newrelic_disable_autorum();
    }

    public function noticeError(int $errno, string $errstr, ?string $errfile = null, ?int $errline = null, ?string $errcontext = null): void
    {
        newrelic_notice_error($errno, $errstr, $errfile, $errline, $errcontext);
    }

    public function noticeThrowable(\Throwable $e, ?string $message = null): void
    {
        newrelic_notice_error($message ?: $e->getMessage(), $e);
    }

    public function enableBackgroundJob(): void
    {
        newrelic_background_job(true);
    }

    public function disableBackgroundJob(): void
    {
        newrelic_background_job(false);
    }

    public function endTransaction(bool $ignore = false): bool
    {
        return newrelic_end_transaction($ignore);
    }

    public function startTransaction(?string $name = null, ?string $license = null): bool
    {
        if (null === $name) {
            $name = ini_get('newrelic.appname');
        }

        if (null === $license) {
            return newrelic_start_transaction($name);
        }

        return newrelic_start_transaction($name, $license);
    }

    public function excludeFromApdex(): void
    {
        newrelic_ignore_apdex();
    }

    public function addCustomTracer(string $name): bool
    {
        return newrelic_add_custom_tracer($name);
    }

    public function setCaptureParams(bool $enabled): void
    {
        newrelic_capture_params($enabled);
    }

    public function stopTransactionTiming(): void
    {
        newrelic_end_of_transaction();
    }

    public function recordDatastoreSegment(callable $func, array $parameters)
    {
        return newrelic_record_datastore_segment($func, $parameters);
    }

    public function setUserAttributes(string $userValue, string $accountValue, string $productValue): bool
    {
        return newrelic_set_user_attributes($userValue, $accountValue, $productValue);
    }

    public function getTraceMetadata(): array
    {
        if (!function_exists('newrelic_get_trace_metadata')) {
            throw new \BadMethodCallException('You need the "newrelic" extension version 9.3 or higher to use this method');
        }

        return newrelic_get_trace_metadata();
    }

    public function getLinkingMetadata(): array
    {
        if (!function_exists('newrelic_get_linking_metadata')) {
            throw new \BadMethodCallException('You need the "newrelic" extension version 9.3 or higher to use this method');
        }

        return newrelic_get_linking_metadata();
    }

    public function isSampled(): bool
    {
        if (!function_exists('newrelic_is_sampled')) {
            throw new \BadMethodCallException('You need the "newrelic" extension version 9.3 or higher to use this method');
        }

        return newrelic_is_sampled();
    }

    public function insertDistributedTracingHeaders(array &$headers): void
    {
        if (!function_exists('newrelic_insert_distributed_trace_headers')) {
            throw new \BadMethodCallException('You need the "newrelic" extension version 9.8 or higher to use this method');
        }

        newrelic_insert_distributed_trace_headers($headers);
    }

    public function acceptDistributedTraceHeaders(array $headers, string $transportType = 'HTTP'): void
    {
        if (!function_exists('newrelic_accept_distributed_trace_headers')) {
            throw new \BadMethodCallException('You need the "newrelic" extension version 9.8 or higher to use this method');
        }

        newrelic_accept_distributed_trace_headers($headers, $transportType);
    }
}
