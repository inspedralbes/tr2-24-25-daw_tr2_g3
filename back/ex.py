import pandas as pd

# Ejemplo de datos de menciones
data = {
    "student_id": [1, 2, 3, 4, 5],  # Incluimos a todos los estudiantes mencionados.
    "likes": [[2, 3], [1, 3], [1, 2], [], []],  # 4 y 5 no mencionan a nadie.
    "dislikes": [[4], [4, 5], [5], [], []],
    "helps": [[3], [1, 3], [2], [], []],
    "insults": [[5], [], [4], [], []],
}

df = pd.DataFrame(data)

import numpy as np

def calculate_features(data):
    features = []
    for row in data:
        positive = len(row['likes']) + len(row['helps'])
        negative = len(row['dislikes']) + len(row['insults'])
        features.append([positive, negative])
    return np.array(features)

features = calculate_features(data)


from sklearn.cluster import KMeans

kmeans = KMeans(n_clusters=3, random_state=42)
clusters = kmeans.fit_predict(features)

print(clusters)  # Cada estudiante tiene un cluster asignado

import matplotlib.pyplot as plt

plt.scatter(features[:, 0], features[:, 1], c=clusters, cmap='viridis')
plt.xlabel("Menciones Positivas")
plt.ylabel("Menciones Negativas")
plt.title("Clustering de Estudiantes")
plt.show()


import networkx as nx

G = nx.Graph()
for row in data:
    student = row['student_id']
    for like in row['likes']:
        G.add_edge(student, like, color='green')
    for dislike in row['dislikes']:
        G.add_edge(student, dislike, color='red')

nx.draw(G, with_labels=True)
plt.show()
