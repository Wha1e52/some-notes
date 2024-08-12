def insertion_sort(array):
    count = 0
    for i in range(1, len(array)):
        for j in range(i, 0, -1):
            if array[j-1] > array[j]:
                count += 1
                array[j], array[j-1] = array[j-1], array[j]
            else:
                break
    return f'{array}, count: {count}'


def insertion_sort2(array):
    count = 0
    for i in range(1, len(array)):
        temp = array[i]
        j = i
        while array[j-1] > temp and j > 0:
            count += 1
            array[j], array[j-1] = array[j-1], array[j]
            j -= 1
    return f'{array}, count: {count}'


my_list = [3, 67, 1, 7, 4, 9, 0, -2, 5, 35, 1, 22, 2, -54, 84, 13, 6, 18, 5, 4]
print(insertion_sort2(my_list))
