const deleteButton = document.querySelector('.list-item-btn-delete');

deleteButton.addEventListener('click', deleteItemUI);

function deleteItemUI(e){
  const itemID = e.target.id;
  itemID.parentNode.removeChild(itemID);
  e.preventDefault();
}