def dijkstra(graph, start):
    cost = [float('inf')] * len(graph)
    is_visited = [False] * len(graph)
    parents = [None] * len(graph)
    cost[start] = 0
    min_cost = 0

    while min_cost < float('inf'):

        is_visited[start] = True
        for i, vertex in enumerate(graph[start]):
            if vertex != 0 and not is_visited[i]:
                if cost[i] > vertex + cost[start]:
                    cost[i] = vertex + cost[start]
                    parents[i] = start

        min_cost = float('inf')

        for i in range(len(graph)):
            if min_cost > cost[i] and not is_visited[i]:
                min_cost = cost[i]
                start = i
    return cost


graph = [
    [0, 0, 1, 1, 9, 0, 0, 0],
    [0, 0, 9, 4, 0, 0, 5, 0],
    [0, 9, 0, 0, 3, 0, 6, 0],
    [0, 0, 0, 0, 0, 0, 0, 0],
    [0, 0, 0, 0, 0, 0, 1, 0],
    [0, 0, 0, 0, 0, 0, 5, 0],
    [0, 0, 7, 0, 8, 1, 0, 0],
    [0, 0, 0, 0, 0, 1, 2, 0],
]

print(dijkstra(graph, 0))
a = [1, 2, 2]
