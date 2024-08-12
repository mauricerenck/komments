<?php
namespace mauricerenck\Komments;

use Kirby\Database\Database;
use Exception;

class DatabaseAbstraction
{
    private $db;

    public function __construct(private string $sqlitePath, private string $databaseName)
    {
        $this->sqlitePath = rtrim($sqlitePath, '/') . '/';
        $this->db = $this->connect();
    }

    public function connect(): ?Database
    {
        if (!file_exists($this->sqlitePath)) {
            mkdir($this->sqlitePath);
        }

        try {
            return $this->db = new Database([
                'type' => 'sqlite',
                'database' => $this->sqlitePath . $this->databaseName,
            ]);
        } catch (Exception $e) {
            return null;
        }
    }
    /**
     * @param array<int,mixed> $fields
     * @param array<int,mixed> $values
     */
    public function insert(string $table, array $fields, array $values): bool
    {
        try {
            $values = $this->convertValuesToSaveDbString($values);
            $query =
                'INSERT INTO ' . $table . '(' . implode(',', $fields) . ') VALUES("' . implode('","', $values) . '")';

            $this->db->query($query);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    /**
     * @param array<int,mixed> $fields
     * @param array<int,mixed> $values
     */
    public function update(string $table, array $fields, array $values, string $filters): bool
    {
        try {
            $values = $this->convertValuesToSaveDbString($values);
            $query = 'UPDATE ' . $table . ' SET ';
            $query .= implode(
                ',',
                array_map(
                    function ($field, $value) {
                        return $field . '="' . $value . '"';
                    },
                    $fields,
                    $values
                )
            );
            $query .= ' ' . $filters;
            $this->db->query($query);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * @param string $table
     * @param array<int,mixed> $fields
     * @param ?string $filters
     */
    public function select(string $table, array $fields, ?string $filters = ''): mixed
    {
        try {
            $query = 'SELECT ' . implode(',', $fields) . ' FROM ' . $table . ' ' . $filters;
            return $this->db->query($query);
        } catch (Exception $e) {
            return false;
        }
    }

    public function delete(string $table, string $filters): bool
    {
        try {
            $query = 'DELETE FROM ' . $table . ' ' . $filters;
            $this->db->query($query);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function query(string $query): bool
    {
        try {
            $this->db->query($query);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
    /**
     * @param array<int,mixed> $values
     */
    public function convertValuesToSaveDbString(array $values): array
    {
        return array_map(function ($value) {
            return $this->convertToSaveDbString($value);
        }, $values);
    }

    public function convertToSaveDbString(string $string): string
    {
        return $this->db->escape($string);
    }

    public function getFormattedDate(): string
    {
        return $this->formatDate(time());
    }

    public function formatDate(int $timestamp): string
    {
        return date('Y-m-d', $timestamp);
    }
}
