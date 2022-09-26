<?php

class DataType {
    const UNKNOWN = 0;
    const INTEGER = 1;
    const STRING = 2;
    const ARRAY = 4;
    const OBJECT = 8;
    const FLOAT = 16;
    const BOOLEAN = 32;
    const NULL = 64;
    const RESOURCE = 128;
    const CALLABLE = 256;
    const ITERABLE = 512;
}
