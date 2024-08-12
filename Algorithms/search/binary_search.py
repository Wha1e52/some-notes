def binary_search(lst, target):
    count = 0
    left = 0
    right = len(lst) - 1
    mid = len(lst) // 2
    while target != lst[mid] and left <= right:

        if target > lst[mid]:
            left = mid + 1
        else:
            right = mid - 1

        mid = (left + right) // 2

        count += 1
    return -1 if left > right else f"Target: {target}, tries: {count}"




my_list = list(range(1000))
target = 456
print(binary_search(my_list, target))

# while count < 50:
#     count += 1
#     mid = len(lst) // 2
#     if lst[mid] == target:
#         return f"Target: {target}, tries: {count}"
#     elif len(lst) == 1:
#         return 'Not found'
#     elif lst[mid] < target:
#         lst = lst[mid:]
#     else:
#         lst = lst[:mid]