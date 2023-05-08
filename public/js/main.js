document.addEventListener('DOMContentLoaded', function() {
    if (localStorage.getItem('notification') === 'closed') {
        document.querySelector('.isolate').style.display = 'none';
    }
});
document.querySelector('#close-notification').addEventListener('click', function() {
    document.querySelector('.isolate').style.display = 'none';
    localStorage.setItem('notification', 'closed');
});


function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
    for (var i = 0; i < rows.length; i++) {
      var row = [], cols = rows[i].querySelectorAll("td, th");
      
      for (var j = 0; j < cols.length; j++) 
        row.push(cols[j].innerText);
      
      csv.push(row.join(","));
    }
  
    // Télécharger le fichier CSV
    var csvFile = new Blob([csv.join("\n")], {type: "text/csv"});
    var downloadLink = document.createElement("a");
    downloadLink.download = filename;
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.style.display = "none";
    document.body.appendChild(downloadLink);
    downloadLink.click();
}


function searchTable() {
    // Récupération de la valeur de recherche
    let input = document.getElementById("searchInput").value.toUpperCase();
  
    // Récupération du tableau et de ses lignes
    let table = document.getElementById("employesTable");
    let rows = table.getElementsByTagName("tr") ;
    // don't count the first row
      rows = Array.from(rows).slice(1);
  
    // Parcours de toutes les lignes et masquage des lignes qui ne correspondent pas à la recherche
    for (let row of rows) {
      let cells = row.getElementsByTagName("td");
      let found = false;
      for (let cell of cells) {
        if (cell.innerHTML.toUpperCase().indexOf(input) > -1) {
          found = true;
          break;
        }
      }
      if (found) {
        row.style.display = "";
      } else {
        row.style.display = "none";
      }
    }
  }
