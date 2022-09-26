<?php

use Error\XcapherError;

class VariableType {
    const SCALAR = DataType::INTEGER | DataType::BOOLEAN | DataType::STRING | DataType::FLOAT;
    const NUMERIC = DataType::INTEGER | DataType::STRING | DataType::FLOAT;
    const URL = 1024 | DataType::STRING;
    const EMAIL = 2048 | DataType::STRING;

    private mixed $variable;
    private int $type;

    public function __construct(mixed $variable) {
        $this->setVariable($variable);
    }

    public function setVariable(mixed $variable): VariableType {
        $this->determineType($variable);
        $this->variable = $variable;
        return $this;
    }

    public function setType(int $type): VariableType {
        $this->type = $type;
        return $this;
    }

    public function determineType(mixed $variable): VariableType {
        $type = match (true) {
            is_string($variable) => DataType::STRING,
            is_int($variable) => DataType::INTEGER,
            is_array($variable) => DataType::ARRAY,
            is_object($variable) => DataType::OBJECT,
            is_float($variable) => DataType::FLOAT,
            is_bool($variable) => DataType::BOOLEAN,
            is_null($variable) => DataType::NULL,
            is_callable($variable) => DataType::CALLABLE,
            is_iterable($variable) => DataType::ITERABLE,
            is_resource($variable) => DataType::RESOURCE,
            default => throw new XcapherError('Unknown datatype: ' . gettype($variable) . '.')
        };
        return $this->setType($type);
    }

    public function to(int $type): mixed {
        $variable = match (true) {
            VariableType::EMAIL === $type => filter_var($this->variable, FILTER_SANITIZE_EMAIL),
            VariableType::URL === $type => filter_var($this->variable, FILTER_SANITIZE_URL),
            DataType::STRING === $type && $this->type !== DataType::ARRAY => (string) $this->variable,
            DataType::INTEGER === $type => (int) $this->variable,
            DataType::ARRAY === $type => (array) $this->variable,
            DataType::FLOAT === $type => (float) $this->variable,
            DataType::BOOLEAN === $type => (bool) $this->variable,
            DataType::OBJECT === $type => (object) $this->variable,
            default => throw new XcapherError('No possibility to cast to datatype ' . gettype($this->variable) . '.')
        };
        return $variable;
    }

    public function is(int $type): bool {
        $is = match (true) {
            $type === self::SCALAR && $this->type & self::SCALAR => true,
            $type === self::NUMERIC && $this->type & self::NUMERIC && is_numeric($this->variable) => true,
            $type === self::URL && $this->type & self::URL && filter_var($this->variable, FILTER_VALIDATE_URL) => true,
            $type === self::EMAIL && $this->type & self::EMAIL && filter_var($this->variable, FILTER_VALIDATE_EMAIL) => true,
            default => $this->type === $type
        };
        return $is;
    }
}
