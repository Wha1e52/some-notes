def selection_sort(array):
    count = 0
    for i in range(len(array)):
        min_idx = i
        for j in range(i + 1, len(array)):
            count += 1
            if array[j] < array[min_idx]:
                min_idx = j
        array[i], array[min_idx] = array[min_idx], array[i]
    return f'{array}, count: {count}'


my_list = [3, 67, 1, 7, 4, 9, 0, -2, 5, 35, 1, 22, 2, -54, 84, 13, 6, 18, 5, 4]
print(selection_sort(my_list))
