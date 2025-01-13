import json
import pandas as pd
import numpy as np
from sklearn.cluster import KMeans
import networkx as nx

# Datos iniciales
# Leer los datos desde un archivo JSON
with open("data.json", "r") as f:
    data = json.load(f)

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
kmeans = KMeans(n_clusters=1, random_state=42)
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
