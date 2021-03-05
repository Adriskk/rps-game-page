# => FUNCTION FILE

# -*- coding: utf-8 -*-

explode = [.2, 0, 0]

points = {
    "amateur": 1,
    "intermediate": 2,
    "expert": 3
}


def extract_from_args(array: str) -> tuple:
    levels = array.split('.')

    amateur = []
    intm = []
    expert = []

    for level in levels:
        if level == 'amateur':
            amateur.append(level)

        elif level == 'intermediate':
            intm.append(level)

        else:
            expert.append(level)

    a_LEN = len(amateur)
    i_LEN = len(intm)
    e_LEN = len(expert)

    return a_LEN, i_LEN, e_LEN


def extract_from_dots(array: list) -> list:
    array = array.split('.')
    return [int(x) for x in array]
