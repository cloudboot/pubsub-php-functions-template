<?php
use CloudEvents\V1\CloudEventInterface;
use Google\CloudFunctions\FunctionsFramework;

// Register the function with Functions Framework.
// This enables omitting the `FUNCTIONS_SIGNATURE_TYPE=cloudevent` environment
// variable when deploying. The `FUNCTION_TARGET` environment variable should
// match the first parameter.
FunctionsFramework::cloudEvent('main', 'main');

function main(CloudEventInterface $event): void
{
  $log = fopen(getenv('LOGGER_OUTPUT') ?: 'php://stderr', 'wb');

  $cloudEventData = $event->getData();
  $pubSubData = base64_decode($cloudEventData['message']['data']);

  $name = $pubSubData ? htmlspecialchars($pubSubData) : '';
  fwrite($log, "It works $name!" . PHP_EOL);
}
