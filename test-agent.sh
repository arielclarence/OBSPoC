#!/bin/bash
set -e

echo "=== CloudWatch Agent Verification Script ==="
echo ""

echo "Step 1: Checking if services are running..."
NGINX_EXPORTER=$(docker ps --format "{{.Names}}" | grep nginx-exporter)
PHP_FPM_EXPORTER=$(docker ps --format "{{.Names}}" | grep php-fpm-exporter)
CLOUDWATCH_AGENT=$(docker ps --format "{{.Names}}" | grep cloudwatch-agent)

# Check if services are running
if [[ ! -z "$NGINX_EXPORTER" ]]; then
  echo "✅ NGINX exporter is running"
else
  echo "❌ NGINX exporter is NOT running"
fi

if [[ ! -z "$PHP_FPM_EXPORTER" ]]; then
  echo "✅ PHP-FPM exporter is running"
else
  echo "❌ PHP-FPM exporter is NOT running"
fi

if [[ ! -z "$CLOUDWATCH_AGENT" ]]; then
  echo "✅ CloudWatch agent is running"
else
  echo "❌ CloudWatch agent is NOT running"
fi

echo ""
echo "Step 2: Testing exporters endpoints..."

echo "Testing NGINX exporter:"
NGINX_STATUS=$(docker exec -it nginx-exporter curl -s http://nginx-exporter:9113/metrics | head -5)
if [[ ! -z "$NGINX_STATUS" ]]; then
  echo "✅ NGINX exporter is responding with metrics:"
  echo "$NGINX_STATUS"
  echo "..."
else
  echo "❌ NGINX exporter is not accessible or not returning metrics"
fi

echo ""
echo "Testing PHP-FPM exporter:"
PHP_STATUS=$(docker exec -it php-fpm-exporter curl -s http://php-fpm-exporter:9253/metrics | head -5)
if [[ ! -z "$PHP_STATUS" ]]; then
  echo "✅ PHP-FPM exporter is responding with metrics:"
  echo "$PHP_STATUS"
  echo "..."
else
  echo "❌ PHP-FPM exporter is not accessible or not returning metrics"
fi

echo ""
echo "Step 3: Checking CloudWatch agent logs..."
CW_LOGS=$(docker logs cloudwatch-agent 2>&1 | tail -30)

# Check for common success patterns
if echo "$CW_LOGS" | grep -q "Successfully started"; then
  echo "✅ CloudWatch agent started successfully"
fi

if echo "$CW_LOGS" | grep -q "Config validation successful"; then
  echo "✅ Configuration validation successful"
fi

if echo "$CW_LOGS" | grep -q "scrape_manager.go"; then
  echo "✅ Prometheus scrape manager is active"
fi

if echo "$CW_LOGS" | grep -q "Scrape"; then
  echo "✅ Scrape operations are being logged"
fi

if echo "$CW_LOGS" | grep -q "Adding target"; then
  echo "✅ Targets are being added to the scrape list"
fi

# Check for common error patterns
if echo "$CW_LOGS" | grep -q "Configuration invalid"; then
  echo "❌ Configuration is invalid"
fi

if echo "$CW_LOGS" | grep -q "failed to load config"; then
  echo "❌ Failed to load configuration"
fi

echo ""
echo "Last 30 log lines from CloudWatch agent:"
echo "----------------------------------------"
echo "$CW_LOGS"
echo "----------------------------------------"

echo ""
echo "Verification complete!"
