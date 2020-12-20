<?php
namespace Library\Models;

use Library\ServiceClasses\Database;


/**
 * Class ActiveRecordEngine
 * @package MyProject\Models
 */


abstract class ActiveRecordEngine
{
    /** @var int */
    protected $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function __set(string $name, $value)
    {
        $camelCaseName = $this->toCamelCase($name);
        $this->$camelCaseName = $value;
    }

    private function toCamelCase(string $data): string
    {
        $result = lcfirst(str_replace('_', '', ucwords($data, '_')));
        return $result;
    }

    public function save(): void
    {
        $props = $this->propToDatabaseFormat();
        if ($this->id !== null) {
            $this->update($props);
        } else {
            $this->insert($props);
        }

    }

    public function update(array $mappedProperties): void
    {
        $db = Database::getConnection();
        $columnsToParameters = [];
        $parametersToValues = [];
        $i = 1;
        foreach ($mappedProperties as $column => $value) {
            $parameter = ':param' . $i;
            $columnsToParameters[] = $column . ' = ' . $parameter;
            $parametersToValues[':param' . $i] = $value;
            $i++;
        }
        $sql = 'UPDATE ' . static::getTable() . ' SET ' . implode(', ', $columnsToParameters) . ' WHERE id = ' . $this->id;
        $db->sqlQuery($sql, $parametersToValues, static::class);
    }

    private function insert(array $mappedProperties): void
    {

        $filteredProperties = array_filter($mappedProperties);
        $columns = [];
        $paramsNames = [];
        $params2values = [];
        foreach ($filteredProperties as $columnName => $value) {
            $columns[] = '`' . $columnName. '`';
            $paramName = ':' . $columnName;
            $paramsNames[] = $paramName;
            $params2values[$paramName] = $value;
        }

        $columnsViaSemicolon = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $paramsNames);

        $sql = 'INSERT INTO ' . static::getTable() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ');';
        $db = Database::getConnection();
        $db->sqlQuery($sql, $params2values, static::class);
        $this->id = $db->getLastInsertId();
        $this->refresh();

    }

    public function delete(int $articleId): void
    {
        $sql = 'DELETE FROM ' . static::getTable() . ' WHERE id = ' . ':id;';
        $db = Database::getConnection();
        $db->sqlQuery($sql, [':id' => $articleId], static::class);
        $this->id = null;
    }

    private function refresh(): void
    {
        $objectFromDb = static::getById($this->id);
        $reflector = new \ReflectionObject($objectFromDb);

        $properties = $reflector->getProperties();

        foreach ($properties as $property) {
            $property->setAccessible(true);
            $propertyName = $property->getName();
            $this->$propertyName = $property->getValue($objectFromDb);
        }
    }

    private function propToDatabaseFormat(): array
    {
        $ref = new \ReflectionObject($this);
        $props = $ref->getProperties();

        $mappedProps = [];
        foreach ($props as $prop) {
            $propName = $prop->getName();
            $propNameAsUnderscore = $this->camelCaseToUnderscore($propName);
            $mappedProperties[$propNameAsUnderscore] = $this->$propName;
        }
        return $mappedProps;
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    /**
     * @return static[]
     */
    public static function findAll(): array
    {
        $db = Database::getConnection();
        return $db->sqlQuery('SELECT * FROM `' . static::getTable() . '`;', [], static::class);
    }

    /**
     * @param int $id
     * @return static|null
     */
    public static function getById(int $id): ?self
    {
        $db = Database::getConnection();
        $entities = $db->sqlQuery(
            'SELECT * FROM `' . static::getTable() . '` WHERE id=:id;',
            [':id' => $id],
            static::class
        );
        return $entities ? $entities[0] : null;
    }

    public static function isValueExist(int $val1, int $val2, string $col1, string $col2): bool
    {
        $db = Database::getConnection();
        $entities = $db->sqlQuery(
            'SELECT * FROM `' . static::getTable() . '` WHERE '.$col1.' = :val1 AND '.$col2.' = :val2',
            [':val1' => $val1,':val2' => $val2],
            static::class
        );
//        echo 'SELECT * FROM `' . static::getTable() . '` WHERE :col1 = :val1 AND :col2 = :val2',
        if ($entities != null){
            return true;
        }
        else{
            return false;
        }
    }

    public static function getCount(int $idBook)
    {
        $db = Database::getConnection();
        $result = $db->simplesqlQuery('SELECT COUNT(*) FROM `' . static::getTable() . '` WHERE id_book=:id;',
            [':id' => $idBook]);
        return $result;
    }






    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $db = Database::getConnection();
        $result = $db->sqlQuery(
            'SELECT * FROM `' . static::getTable() . '` WHERE `' . $columnName . '` = :value LIMIT 1;',
            [':value' => $value],
            static::class
        );
        if ($result === []) {
            return null;
        }
        return $result[0];
    }

    abstract protected static function getTable(): string;
}