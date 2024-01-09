document.addEventListener("DOMContentLoaded", () => {
    //change value checkbox disjuntor
    let checkboxVisibility = document.querySelector('input[name="visibility"]');
    if (checkboxVisibility) {
        checkboxVisibility.addEventListener("change", function () {
            this.value = this.checked ? "enabled" : "disabled";
        });
    }
    let checkboxStatus = document.querySelector('input[name="status"]');
    if (checkboxStatus) {
        checkboxStatus.addEventListener("change", function () {
            this.value = this.checked ? "enabled" : "disabled";
        });
    }
    

    //close feedback message toast
    const closeButtons = document.querySelectorAll(
        '[data-dismiss="toast"][aria-label="Close"]'
    );
    closeButtons.forEach((closeButton) =>
        closeButton.addEventListener("click", (event) =>
            event.target.closest(".toast").classList.remove("show")
        )
    );

    let width = 0;
    const toastSuccess = document.querySelector(".toast .progress-close");

    if (toastSuccess) {
        const hideMessage = setInterval(() => {
            width++;
            toastSuccess.style.width = `${width}%`;
            if (width >= 100) {
                toastSuccess.closest(".toast").classList.remove("show");
                clearInterval(hideMessage);
            }
        }, 30);
    }
    const toastError = document.querySelector(".toast .progress-close");

    if (toastError) {
        const hideMessage = setInterval(() => {
            width++;
            toastError.style.width = `${width}%`;
            if (width >= 100) {
                toastError.closest(".toast").classList.remove("show");
                clearInterval(hideMessage);
            }
        }, 30);
    }    



    //Drag and drop menu
    const dadPrimaryArea = document.querySelectorAll(".drag-and-drop .card");
    const dadPItems = document.querySelectorAll(".dad-item");
    let elementBeingDragged;

    dadPrimaryArea.forEach((e) => {
        e.setAttribute("draggable", true);
        e.addEventListener("dragover", (e) => onDragOver(e));
    });

    dadPItems.forEach((e) => {
        e.setAttribute("draggable", true);
    });

    document.addEventListener("dragstart", ({ target }) => {
        target.classList.add("is-dragging");
        elementBeingDragged = target;
        target.style.opacity = "0.5";
    });

    document.addEventListener("dragend", ({ target }) => {
        target.classList.remove("is-dragging");
        target.style.opacity = "1";
    });

    function onDragOver(item) {
        const dadFather = item.target.closest(".card");

        const move = newPosition(dadFather, item.clientY);

        if (move) {
            move.insertAdjacentElement("afterend", elementBeingDragged);
        } else {
            dadFather.prepend(elementBeingDragged);
        }
    }

    function newPosition(boxes, positionY) {
        let brothersBox = boxes.querySelectorAll(".dad-item:not(.is-dragging)");
        let result;

        for (let card_item of brothersBox) {
            const currentCard = card_item.getBoundingClientRect();
            const currentCardCenterY = currentCard.y + currentCard.height / 2;

            if (positionY >= currentCardCenterY) result = card_item;
        }
        return result;
    }

    $(document).ready(function () {
       $('#link_type').change(function () {
            var selectedOption = $(this).val();
            if (selectedOption === 'external') {
               $('#external_link_div').show();
            } else {
               $('#external_link_div').hide();
            }
        });
    });

    $(document).ready(function () {
       $('#type_item').change(function () {
            var selectedOption = $(this).val();
            if (selectedOption == 'internal') {
               $('#internal_link').show();
               $('#external_link').hide();
            } else {
                $('#external_link').show();
                $('#internal_link').hide();
            }
        });
    });

    $(document).ready(function () {
        $('#employment_type').change(function () {
            var selectedOption = $(this).val();
            if (selectedOption == 'Contractor') {
                $('#terceirizado').show();
                $('#terceirizado-secretary').show();
            }else {
                $('#terceirizado').hide();
                $('#terceirizado-secretary').hide();
            }

            if(selectedOption == 'Intern' || selectedOption == 'Contractor'  ){
                $('#terceirizado-secretary').show();
            }else {
                $('#terceirizado-secretary').hide();
            }
        });
    });

});