function addFieldSet() {
    let container = document.getElementById("additional-fields");

    // Create a wrapper div
    let fieldSet = document.createElement("div");
    fieldSet.className = "relative bg-gray-100 p-4 rounded-lg shadow-md border border-gray-300";

    // Create Program select dropdown
    let programDiv = document.createElement("div");
    programDiv.className = "mb-2";
    let programLabel = document.createElement("label");
    programLabel.className = "block mb-2 text-sm font-medium text-gray-700";
    programLabel.textContent = "Program";

    let programSelect = document.createElement("select");
    programSelect.name = "program[]";
    programSelect.className = "program-select bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5";

    // Populate Program dropdown
    let programOptions = `<option value="">Select program</option>
                          <option value="AllStudents">All Students</option>`;
    programs.forEach(program => {
        programOptions += `<option value="${program.program}">${program.program}</option>`;
    });
    programSelect.innerHTML = programOptions;

    programDiv.appendChild(programLabel);
    programDiv.appendChild(programSelect);

    // Create Year select dropdown
    let yearDiv = document.createElement("div");
    let yearLabel = document.createElement("label");
    yearLabel.className = "block mb-2 text-sm font-medium text-gray-700";
    yearLabel.textContent = "Year";

    let yearSelect = document.createElement("select");
    yearSelect.name = "year[]";
    yearSelect.className = "year-select bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5";

    // Populate Year dropdown
    let yearOptions = `<option value="">Select year</option>`;
    years.forEach(year => {
        yearOptions += `<option value="${year.acad_year}">${year.acad_year}</option>`;
    });
    yearSelect.innerHTML = yearOptions;

    yearDiv.appendChild(yearLabel);
    yearDiv.appendChild(yearSelect);

    // Remove button
    let removeBtn = document.createElement("button");
    removeBtn.className = "absolute top-2 right-2 bg-red-500 text-white text-xs px-2 py-1 rounded-lg hover:bg-red-600";
    removeBtn.textContent = "Remove";
    removeBtn.onclick = function () {
        container.removeChild(fieldSet);
    };

    // Append all elements
    fieldSet.appendChild(removeBtn);
    fieldSet.appendChild(programDiv);
    fieldSet.appendChild(yearDiv);

    // Append fieldset to container
    container.appendChild(fieldSet);
}
