import "./admin-stats.scss";
import "./admin-app.scss";
import "./admin-app";
import "chart.js/dist/chart";
import { jsPDF } from "jspdf";
import html2canvas from "html2canvas";

const labels = ["PF15", "PF30", "PF50+"];

if (document.getElementById("response")) {
  const spfData = document.getElementById("response").value.split(",");

  // Data of the graph
  const data = {
    labels: labels,
    datasets: [
      {
        label: "SPF stats",
        backgroundColor: ["#A42C23", "#DB6A39", "#EDA687"],
        borderColor: ["#A42C23", "#DB6A39", "#EDA687"],
        data: spfData,
      },
    ],
  };

  // config of the graph
  const config = {
    type: "doughnut",
    data: data,
    options: {},
  };

  // Init graph
  const chart = new Chart(document.getElementById("myChart"), config);
}

function savePDF(title) {
  html2canvas(document.getElementById("myChart")).then(function (canvas) {
    var img = canvas.toDataURL();
    var docPDF = new jsPDF();
    docPDF.text(title, docPDF.internal.pageSize.getWidth() / 2, 20, "center");
    docPDF.addImage(img, "JPEG", 40, 30, 150, 150);
    docPDF.save();
  });
}
window.savePDF = savePDF;
