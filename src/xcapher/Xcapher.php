<?php

/**
 * The Xcapher class, a simple way of escaping any value.
 *
 * Best used through th x() funtion
 *
 * @author John Larsen
 * @license MIT
 */

use Error\XcapherError;

class Xcapher {
    private VariableType $variable;
    private $db;

    public function __construct(mixed $variable) {
        $this->setVariable($variable);
    }

    public function setVariable(mixed $variable): Xcapher {
        $this->variable = new VariableType($variable);
        return $this;
    }

    public function setDb(mixed $connection = null): Xcapher {
        if ($connection) {
            $this->db = $connection;
        }

        return $this;
    }

    public function getDb(): mixed {
        return $this->db;
    }


    public function string(): string {
        return $this->variable->to(DataType::STRING);
    }

    public function int(): int {
        return $this->variable->to(DataType::INTEGER);
    }

    public function array(): array {
        return $this->variable->to(DataType::ARRAY);
    }

    public function object(): object {
        return $this->variable->to(DataType::OBJECT);
    }

    public function float(): float {
        return $this->variable->to(DataType::FLOAT);
    }

    public function bool(): bool {
        return $this->variable->to(DataType::BOOLEAN);
    }

    public function email(): string {
        return $this->variable->to(VariableType::EMAIL);
    }

    public function url(): string {
        return $this->variable->to(VariableType::URL);
    }

    public function escape(mixed $connection = null): mixed {
        $db = $this->setDb($connection)->getDb();
        if ($db && $this->variable->is(VariableType::SCALAR)) {
            $escaped = match (true) {
                is_a($db, 'mysqli') => mysqli_real_escape_string($db, $this->string()),
                is_a($db, 'PgSql\Connection') => pg_escape_string($db, $this->string()),
                default => throw new XcapherError('Not a valid database connection.')
            };
            return $escaped;
        }
        throw new XcapherError($db ? 'No database connection.' : 'Variable to escape is not scalar value.');
    }

    public function htmlEntityEncode(int $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, ?string $encoding = null, bool $double_encode = true): string {
        if ($this->variable->is(DataType::STRING)) {
            return htmlentities($this->string(), $flags, $encoding, $double_encode);
        }
        throw new XcapherError('Variable not a string.');
    }

    public function htmlEntityDecode(int $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML401, ?string $encoding = null): string {
        if ($this->variable->is(DataType::STRING)) {
            return html_entity_decode($this->string(), $flags, $encoding);
        }
        throw new XcapherError('Variable not a string.');
    }

    public function urlEncode(): string {
        if ($this->variable->is(VariableType::URL)) {
            return urlencode($this->string());
        }
        throw new XcapherError('Variable is not a valid url.');
    }

    public function urlDecode(): string {
        if ($this->variable->is(VariableType::URL)) {
            return urldecode($this->string());
        }
        throw new XcapherError('Variable is not a valid url.');
    }
}
