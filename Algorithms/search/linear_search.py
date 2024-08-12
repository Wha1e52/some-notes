def linear_search(lst, target):
    for i in range(len(lst)):
        if lst[i] == target:
            return i
    return None


my_list = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10]
print(linear_search(my_list, 4))

