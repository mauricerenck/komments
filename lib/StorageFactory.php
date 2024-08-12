<?php
namespace mauricerenck\Komments;

use Exception;

class StorageFactory
{
    public static function create(?string $storageType = null): StorageSqlite | StorageMarkdown
    {
        $storageType = $storageType ?? option('mauricerenck.komments.storage.type', 'markdown');

        switch ($storageType) {
            case 'markdown':
                return new StorageMarkdown();
            case 'sqlite':
                return new StorageSqlite();
            // case 'json':
            //     return new StorageJson();
            default:
                throw new Exception('Invalid storage type');
        }
    }
}
