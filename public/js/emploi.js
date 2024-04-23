const cellules=document.querySelectorAll('.cellule')
const btn_close=document.querySelector('btn-close')
    //   cellules.addeventListener('click',()=>{
    //     console.log('hhh')
    //   })
      cellules.forEach(cellule => {
        // Ajoutez un écouteur d'événements 'click' à chaque cellule
        cellule.addEventListener('click',()=> {
            cellule.classList.add('active_cellule')
            // console.log(cellule.id)
        });
    });
    btn_close.onclick=()=>{
        // cellules.forEach(cellule=>{
        //     cellule.classList.remove('active_cellule')
        // })
    }
    const date_debu=document.getElementById()