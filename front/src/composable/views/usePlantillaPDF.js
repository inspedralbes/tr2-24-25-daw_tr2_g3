import {onMounted, reactive} from "vue";
import html2canvas from "html2canvas";
import jsPDF from "jspdf";

export function usePlantillaPDF(props) {
  const student = reactive({data: props.student});
  const groups = reactive({data: props.group});

  onMounted(async () => {
    console.log("Stundet", student.data);
  })

  const exportPDF = async () => {
    const content = document.getElementById("content-pdf");
    const canvas = await html2canvas(content, { scale: 2 });
    const imgData = canvas.toDataURL("image/png");
    const pdfDoc = new jsPDF("p", "mm", "a4");

    const imgWidth = 210; // Ancho del PDF en mm
    const pageHeight = 300; // Altura del PDF en mm
    const imgHeight = (canvas.height * imgWidth) / canvas.width;

    let position = 0;

    if (imgHeight > pageHeight) {
      let remainingHeight = imgHeight;

      while (remainingHeight > 0) {
        pdfDoc.addImage(imgData, "PNG", 0, position, imgWidth, imgHeight);
        remainingHeight -= pageHeight;
        position -= pageHeight;
        if (remainingHeight > 0) pdfDoc.addPage();
      }
    } else {
      pdfDoc.addImage(imgData, "PNG", 0, 0, imgWidth, imgHeight);
    }
    student.data.forEach(studen => {
    pdfDoc.save(`${studen.name}_${studen.lastname}.pdf`);

    })
  };

  return {
    student,
    groups,
    exportPDF
  }
}
