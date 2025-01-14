<template>

  <span class="text-2xl font-bold">Estudiantes</span>
  <div>
    <label for="wizard-select" class="block text-lg mt-4">Selecciona un Wizard:</label>
    <select id="wizard-select" v-model="selectedWizard" @change="onWizardChange" class="mt-2 p-2 border rounded">
      <option value="" disabled selected>Selecciona un wizard</option>
      <option v-for="wizard in wizards" :key="wizard.form_id" :value="wizard">
        {{ wizard.name }}
      </option>
    </select>
  </div>

  <div>
    <div ref="sociogram" class="sociogram full" ></div>
  </div>

</template>

<script>
import * as d3 from 'd3';
import LayoutMain from "@/layout/LayoutMain.vue";

export default {
  components: {LayoutMain},
  props: {
    dataProps: {
      type: Object,
      required: true
    },
    wizards: {
      type: Object,
      required: true
    }
  },
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
        {source: 9, target: 7}, {source: 10, target: 9}, {source: 3, target: 7}
      ],
      selectedWizard: null, // El wizard seleccionado
    };
  },
  mounted() {

  },
  methods: {
    // createSociogram() {
    //   const width = this.$refs.sociogram.clientWidth; // 100% of the container width
    //   const height = this.$refs.sociogram.clientHeight; // 100% of the container height
    //
    //   const svg = d3.select(this.$refs.sociogram)
    //       .append('svg')
    //       .attr('width', width)
    //       .attr('height', height);
    //
    //   const simulation = d3.forceSimulation(this.nodes)
    //       .force('link', d3.forceLink(this.links).id(d => d.id).distance(100))
    //       .force('charge', d3.forceManyBody().strength(-200))
    //       .force('center', d3.forceCenter(width / 2, height / 2));
    //
    //   const link = svg.selectAll('.link')
    //       .data(this.links)
    //       .enter().append('line')
    //       .attr('class', 'link')
    //       .attr('stroke', '#999')
    //       .attr('stroke-width', 2);
    //
    //   const node = svg.selectAll('.node')
    //       .data(this.nodes)
    //       .enter().append('g')
    //       .attr('class', 'node')
    //       .attr('transform', d => `translate(${d.x || 0}, ${d.y || 0})`);
    //
    //   // Crear tarjetas (cards)
    //   const card = node.append('foreignObject')
    //       .attr('width', 80) // Ajustar el tamaño de la tarjeta
    //       .attr('height', 100) // Ajustar la altura de la tarjeta
    //       .attr('x', -40) // Alineación centrada
    //       .attr('y', -50) // Alineación centrada
    //       .append('xhtml:div')
    //       .attr('class', 'node-card');
    //
    //   // Agregar contenido a la tarjeta
    //   card.append('div')
    //       .style('width', '80px')   // Establecer el ancho de la tarjeta
    //       .style('height', '80px')  // Establecer la altura de la tarjeta
    //       .html(d => `
    //         <div class="max-w-sm w-full bg-white rounded-full border p-2 flex flex-col items-center">
    //           <div class="flex justify-center mb-2">
    //             <div class="icon-container">
    //               <svg class="h-8 w-8 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
    //                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14c3.866 0 7 3.134 7 7H5c0-3.866 3.134-7 7-7zM12 2a4 4 0 110 8 4 4 0 010-8z" />
    //               </svg>
    //             </div>
    //           </div>
    //           <p class="text-center text-sm font-semibold mb-0">${d.name}</p>
    //         </div>
    //       `);
    //
    //   simulation.on('tick', () => {
    //     link
    //         .attr('x1', d => d.source.x)
    //         .attr('y1', d => d.source.y)
    //         .attr('x2', d => d.target.x)
    //         .attr('y2', d => d.target.y);
    //
    //     node
    //         .attr('transform', d => `translate(${d.x}, ${d.y})`);
    //   });
    // }

    selectWizard(form_id, group_id){
      fetch('http://localhost:3000/load-data',{
        method: 'POST',
        headers: {
          'Accept': 'application/json',
          'Content-Type': 'application/json',
        },
        body:JSON.stringify({
          "form_id": form_id,
          "group_id": group_id
        })
      })
        .then(response => response.json())
        .then(data => {
          console.log(data)
          this.nodes = data.nodes;
          this.links = data.links;
          this.createSociogram();
        });
    },
    onWizardChange() {
      console.log("change")
      console.log(this.selectedWizard)
      if (this.selectedWizard) {
        this.selectWizard(this.selectedWizard.id, this.selectedWizard.group_id);
      }
    },

    createSociogram() {


      const width = this.$refs.sociogram.clientWidth; // 100% of the container width
      const height = this.$refs.sociogram.clientHeight;

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
        .attr('stroke', d => d.type === 'like' ? 'green' : 'red')
        .attr('stroke-width', 2);

      const node = svg.selectAll('.node')
        .data(this.nodes)
        .enter().append('g')
        .attr('class', 'node')
        .attr('transform', d => `translate(${d.x || 0}, ${d.y || 0})`)
        .call(
          d3.drag()
            .on('start', (event, d) => {
              if (!event.active) simulation.alphaTarget(0.3).restart();
              d.fx = d.x;
              d.fy = d.y;
            })
            .on('drag', (event, d) => {
              d.fx = event.x;
              d.fy = event.y;
            })
            .on('end', (event, d) => {
              if (!event.active) simulation.alphaTarget(0);
              d.fx = null;
              d.fy = null;
            })
        );

      // Crear tarjetas (cards)
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

// Actualizar la posición de la tarjeta durante la simulación
      simulation.on('tick', () => {
        link
          .attr('x1', d => d.source.x)
          .attr('y1', d => d.source.y)
          .attr('x2', d => d.target.x)
          .attr('y2', d => d.target.y);

        node
          .attr('transform', d => `translate(${d.x}, ${d.y})`); // Mover el nodo con su tarjeta

        card
          .attr('x', d => d.x - 40) // Mover la tarjeta con el nodo
          .attr('y', d => d.y - 50); // Ajustar la posición de la tarjeta según el nodo
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

.full{
  height: 100vh;
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
