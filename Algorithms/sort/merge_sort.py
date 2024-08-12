def merge(array1, array2):
    """Слияние двух УПОРЯДОЧЕННЫХ списков"""

    new_array = []
    length1 = len(array1)
    length2 = len(array2)

    i = j = 0

    for _ in range(length1 + length2):
        if j >= length2 or (i < length1 and array1[i] <= array2[j]):
            new_array.append(array1[i])
            i += 1
        else:
            new_array.append(array2[j])
            j += 1
    return new_array


def split_and_merge_list(array):
    middle = len(array) // 2  # деление массива на два примерно равной длины
    array1 = array[:middle]
    array2 = array[middle:]

    if len(array1) > 1:  # если длина 1-го списка больше 1, то делим дальше
        array1 = split_and_merge_list(array1)
    if len(array2) > 1:  # если длина 2-го списка больше 1, то делим дальше
        array2 = split_and_merge_list(array2)
    res = merge(array1, array2)  # слияние двух отсортированных списков в один
    return res


a = [9, 5, -3, 4, 7, 8, -8]
print(split_and_merge_list(a))
