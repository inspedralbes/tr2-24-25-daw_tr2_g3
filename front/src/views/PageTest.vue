<template>
  <div ref="sociogram" class="sociogram" style="height: 100vh;"></div>
</template>

<script>
import * as d3 from 'd3';

export default {
  data() {
    return {
      nodes: [
        {id: 1, name: 'Node 1'}, {id: 2, name: 'Node 2'}, {id: 3, name: 'Node 3'}, {id: 4, name: 'Node 4'},
        {id: 5, name: 'Node 5'}, {id: 6, name: 'Node 6'}, {id: 7, name: 'Node 7'}, {id: 8, name: 'Node 8'},
        {id: 9, name: 'Node 9'}, {id: 10, name: 'Node 10'}, {id: 11, name: 'Node 11'}, {id: 12, name: 'Node 12'}
      ],
      links: [
        {source: 1, target: 8}, {source: 2, target: 10},
        {source: 3, target: 9}, {source: 4, target: 7},
        {source: 5, target: 6}, {source: 6, target: 10},
        {source: 7, target: 11}, {source: 8, target: 12},
        {source: 9, target: 7}, {source: 10, target: 9},{source: 3, target: 7}
      ]
    };
  },
  mounted() {
    this.createSociogram();
  },
  methods: {
    createSociogram() {
      const width = this.$refs.sociogram.clientWidth; // 100% of the container width
      const height = this.$refs.sociogram.clientHeight; // 100% of the container height

      const svg = d3.select(this.$refs.sociogram)
          .append('svg')
          .attr('width', width)
          .attr('height', height);

      const simulation = d3.forceSimulation(this.nodes)
          .force('link', d3.forceLink(this.links).id(d => d.id).distance(100))
          .force('charge', d3.forceManyBody().strength(-200))
          .force('center', d3.forceCenter(width / 2, height / 2));

      const link = svg.selectAll('.link')
          .data(this.links)
          .enter().append('line')
          .attr('class', 'link')
          .attr('stroke', '#999')
          .attr('stroke-width', 2);

      const node = svg.selectAll('.node')
          .data(this.nodes)
          .enter().append('g')
          .attr('class', 'node')
          .attr('transform', d => `translate(${d.x || 0}, ${d.y || 0})`);

      // Crear tarjetas (cards)
      const card = node.append('foreignObject')
          .attr('width', 80) // Ajustar el tamaño de la tarjeta
          .attr('height', 100) // Ajustar la altura de la tarjeta
          .attr('x', -40) // Alineación centrada
          .attr('y', -50) // Alineación centrada
          .append('xhtml:div')
          .attr('class', 'node-card');

      // Agregar contenido a la tarjeta
      card.append('div')
          .style('width', '80px')   // Establecer el ancho de la tarjeta
          .style('height', '80px')  // Establecer la altura de la tarjeta
          .html(d => `
            <div class="max-w-sm w-full bg-white rounded-full border p-2 flex flex-col items-center">
              <div class="flex justify-center mb-2">
                <div class="icon-container">
                  <svg class="h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c3.866 0 7 3.134 7 7H5c0-3.866 3.134-7 7-7zM12 2a4 4 0 110 8 4 4 0 010-8z" />
                  </svg>
                </div>
              </div>
              <p class="text-center text-sm font-semibold mb-0">${d.name}</p>
            </div>
          `);

      simulation.on('tick', () => {
        link
            .attr('x1', d => d.source.x)
            .attr('y1', d => d.source.y)
            .attr('x2', d => d.target.x)
            .attr('y2', d => d.target.y);

        node
            .attr('transform', d => `translate(${d.x}, ${d.y})`);
      });
    }
  }
};
</script>

<style scoped>
.sociogram {
  width: 100%;
  height: 100%;
}

.link {
  stroke: #999;
  stroke-width: 1.5px;
}

.node-card {
  background-color: #69b3a2;
  border-radius: 50%; /* Hacer que la tarjeta tenga bordes redondeados */
  color: white;
  display: flex;
  justify-content: center;
  align-items: center;
  font-size: 14px;
  padding: 10px;
  text-align: center;
  position: relative;
}

.node {
  cursor: pointer;
}

.node-card .card-content {
  text-align: center;
}

.node-card .card-content p {
  margin-top: 5px;
  font-size: 12px; /* Reducir el tamaño del texto */
}

.icon-container {
  width: 25px;
  height: 25px;
  background-color: white;
  border-radius: 50%;
  border: 2px solid #ccc;
  display: flex;
  justify-content: center;
  align-items: center;
}

.node-card .card-content svg {
  width: 20px;
  height: 20px;
  color: #69b3a2;
}
</style>
