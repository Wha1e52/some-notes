def bubble_sort(array):
    count = 0
    for i in range(len(array)):
        for j in range(len(array) - (i+1)):
            if array[j+1] < array[j]:
                array[j], array[j+1] = array[j+1], array[j]
            count += 1
    return f'{array}, count: {count}'


my_list = [3, 67, 1, 7, 4, 9, 0, -2, 5, 35, 1, 22, 2, -3, 84, 13, 6, 18, 5, 4]
print(bubble_sort(my_list))