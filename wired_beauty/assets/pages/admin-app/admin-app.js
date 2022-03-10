document.addEventListener("DOMContentLoaded", () => {
  const edit_actions = document.querySelectorAll(".js-row-edit-action");

  setActions(edit_actions, "edit");
});

function setActions(actions, type) {

    actions.forEach((action) => {
        if (type == "edit") {
      let href = action
        .closest("tr")
        .querySelector(".actions .action-edit").href;
      action.innerHTML = "<a href='" + href + "'>" + action.innerHTML + "</a>";
    }
  });
}
