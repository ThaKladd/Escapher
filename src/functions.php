<?php

/**
 * This function gives quick access to the Xchaper class
 * @param mixed $variable The variable to do actions upon
 * @return Xcapher the Xcapher object to begin with
 */
function x(mixed $variable): Xcapher {
    return new Xcapher($variable);
}
