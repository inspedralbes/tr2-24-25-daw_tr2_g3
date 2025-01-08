import json
import pandas as pd
import numpy as np
from sklearn.cluster import KMeans
import networkx as nx

# Datos iniciales
data = {
    "student_id": list(range(1, 31)),
    "likes": [
        [2, 3], [1, 3, 4], [1, 2, 5], [6], [], 
        [7, 8], [6], [7, 9], [10], [8, 9], 
        [12, 13], [11], [11, 14], [13, 15], [16],
        [14], [15, 17], [16], [18], [19],
        [20, 22], [21], [23, 24], [25], [23],
        [], [28, 29], [26, 30], [27], [26, 28]
    ],
    "dislikes": [
        [4], [5], [6, 7], [1], [], 
        [10], [], [6], [7], [8],
        [14], [15], [], [11], [12],
        [], [18, 19], [], [17], [],
        [23], [22, 25], [21], [26], [],
        [27], [30], [], [28], [29]
    ],
    "helps": [
        [3], [1, 3], [2], [5], [], 
        [9], [8], [10], [], [6],
        [12], [13, 14], [], [15], [16],
        [17], [18], [], [19], [],
        [21], [22], [23], [24], [25],
        [], [27], [28], [29], [30]
    ],
    "insults": [
        [5], [], [4], [], [], 
        [6], [7], [8], [9], [],
        [10], [], [12], [], [14],
        [], [16], [15], [17], [18],
        [20], [21], [], [23], [24],
        [26], [27], [28], [29], []
    ],
}

df = pd.DataFrame(data)

# Calcular características para clustering
def calculate_features(df):
    features = []
    for _, row in df.iterrows():
        positive = len(row['likes']) + len(row['helps'])
        negative = len(row['dislikes']) + len(row['insults'])
        features.append([positive, negative])
    return np.array(features)

features = calculate_features(df)

# K-Means Clustering
kmeans = KMeans(n_clusters=3, random_state=42)
clusters = kmeans.fit_predict(features)
df['cluster'] = clusters

# Crear datos para D3.js
nodes = [{"id": row["student_id"], "name": f"Student {row['student_id']}", "cluster": int(row["cluster"])} for _, row in df.iterrows()]
links = []

for _, row in df.iterrows():
    student = row['student_id']
    for like in row['likes']:
        links.append({"source": student, "target": like, "type": "like"})
    for dislike in row['dislikes']:
        links.append({"source": student, "target": dislike, "type": "dislike"})

# Guardar datos como JSON
graph_data = {"nodes": nodes, "links": links}

with open("graph_data.json", "w") as f:
    json.dump(graph_data, f)

print("Datos exportados a graph_data.json")
