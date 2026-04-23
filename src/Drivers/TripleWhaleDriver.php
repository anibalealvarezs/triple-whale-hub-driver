<?php

namespace Anibalealvarezs\TripleWhaleHubDriver\Drivers;

use Anibalealvarezs\ApiDriverCore\Interfaces\SyncDriverInterface;
use Anibalealvarezs\ApiDriverCore\Interfaces\AuthProviderInterface;
use Anibalealvarezs\ApiDriverCore\Traits\HasUpdatableCredentials;
use Symfony\Component\HttpFoundation\Response;
use Psr\Log\LoggerInterface;
use DateTime;
use Anibalealvarezs\ApiDriverCore\Interfaces\SeederInterface;
use Anibalealvarezs\ApiDriverCore\Traits\SyncDriverTrait;

class TripleWhaleDriver implements SyncDriverInterface
{
    use SyncDriverTrait;

    /**
     * Get the display label for the channel.
     * 
     * @return string
     */
    public static function getChannelLabel(): string
    {
        return 'TripleWhale';
    }

    /**
     * Get the display icon for the channel.
     * 
     * @return string
     */
    public static function getChannelIcon(): string
    {
        return 'TW';
    }


    /**
     * @inheritdoc
     */
    public function fetchAvailableAssets(bool $throwOnError = false): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function validateAuthentication(): array
    {
        return [
            'success' => true,
            'message' => 'Status unknown for this driver.',
            'details' => []
        ];
    }


    use HasUpdatableCredentials;

    private ?AuthProviderInterface $authProvider = null;
    private ?LoggerInterface $logger = null;

    public function __construct(?AuthProviderInterface $authProvider = null, ?LoggerInterface $logger = null)
    {
        $this->authProvider = $authProvider;
        $this->logger = $logger;
    }

    public function setAuthProvider(AuthProviderInterface $provider): void
    {
        $this->authProvider = $provider;
    }

    public function getAuthProvider(): ?AuthProviderInterface
    {
        return $this->authProvider;
    }

    public function getChannel(): string
    {
        return 'triplewhale';
    }

    public function sync(
        DateTime $startDate,
        DateTime $endDate,
        array $config = [],
        ?callable $shouldContinue = null,
        ?callable $identityMapper = null
    ): Response

    {
        if ($this->logger) {
            $this->logger->info("TripleWhaleDriver (Modular): No native implementation yet. Sync skipped.");
        }
        
        return new Response(json_encode([
            'status' => 'skipped',
            'message' => 'TripleWhale modular driver placeholder executed successfully.'
        ]));
    }

    public function getApi(array $config = []): mixed
    {
        return null;
    }

    /**
     * @inheritdoc
     */
    public function getConfigSchema(): array
    {
        return [
            'global' => [
                'enabled' => false,
                'cache_history_range' => '1 year',
                'cache_aggregations' => false,
            ],
            'entity' => [
                'id' => '',
                'shop_domain' => '',
                'enabled' => true,
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function validateConfig(array $config): array
    {
        return \Anibalealvarezs\ApiDriverCore\Services\ConfigSchemaRegistryService::hydrate(
            $this->getChannel(),
            'global',
            $config,
            $this->getConfigSchema()
        );
    }

    /**
     * @inheritdoc
     */
    public function seedDemoData(SeederInterface $seeder, array $config = []): void
    {
        // Placeholder for future implementation
    }
    public function boot(): void
    {
    }

    public static function getAssetPatterns(): array
    {
        return [];
    }



    /**
     * @inheritdoc
     */
    public function initializeEntities(array $config = []): array

    {
        return ['initialized' => 0, 'skipped' => 0];
    }

    /**
     * @inheritdoc
     */
    public function reset(string $mode = 'all', array $config = []): array

    {
        return ['cleared' => 0, 'mode' => $mode];
    }

    public function updateConfiguration(array $newData, array $currentConfig): array
    {
        return $currentConfig;
    }

    public function prepareUiConfig(array $channelConfig): array
    {
        return [];
    }
}

