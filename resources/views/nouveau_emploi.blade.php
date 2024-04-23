<x-master title="nouveau emploi">
<div class="container w-50" style="background-color: white; border-radius: 13px">
            <form  id="form1" class="container-sm py-3 mb-2" action="{{route('ajouter_emploi')}}" method="post">
               @csrf
             <div class="mb-3 ">
               <label for="exampleInputEmail1" class="form-label">date debu</label>
               <input id="date_debu"  type="date" name="date_debu" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" autocomplete="off">
               <div id="emailHelp" class="form-text" style="color:red;"></div>
               @error('date_debu')
              <div id="emailHelp" class="form-text" style="color:red;">{{$message}}</div>
              @enderror
             </div>
             <div class="mb-3">
               <label for="exampleInputPassword1" class="form-label">date fin</label>
               <input id="date_fin" style="pointer-events: none;" type="date" name="date_fin" class="form-control" id="exampleInputPassword1"autocomplete="off">
             </div>
             <div class="mb-3 form-check">
               <input name="base_sur_emploi" type="checkbox" class="form-check-input " id="exampleCheck1" autocomplete="off">
               <label class="form-check-label" for="exampleCheck1">base sur emploi</label>
             </div>
              <select name="emploi_temps_ancienne" class="form-select mb-2 px-2 w-100 mx-auto" style="display:none;" aria-label="Default select example" autocomplete="off">
              <option selected value="">choisissez l'emploi du temps a base</option>
              @foreach($emplois as $emploi)
               <option value="{{$emploi->id}}">{{$emploi->date_debu}}</option>ch
              @endforeach
             </select>
             <div id="select_erreur" style="color:red;"> </div>              
             <button type="submit" class="btn btn-info d-block mx-auto">creer emploi</button>
           </form>
            </div>
        </div>
    </div>
</div>
<script>
 const base_sur_emploi = document.querySelector('[type="checkbox"]');
const tous_les_emplois = document.querySelector('.form-select');
const date_debu_form = document.getElementById('date_debu');
const emailHelp = document.getElementById('emailHelp');
const select_erreur = document.getElementById('select_erreur');
const date_fin_form=document.getElementById('date_fin');
base_sur_emploi.onclick = () => {
    if (base_sur_emploi.checked == false) {
        tous_les_emplois.style.display = "none";
    } else {
        tous_les_emplois.style.display = "block";
    }
};
date_debu_form.addEventListener("input", () => {
    const dateDebu = new Date(date_debu_form.value);
    const day = dateDebu.getDay();
    if (day !== 1) {
        emailHelp.innerText = "Le jour doit être lundi.";
    } else {
        emailHelp.innerText = "";
        const date_fin = new Date(date_debu_form.value);
        date_fin.setDate(date_fin.getDate() + 5);
        const date_fin_pre = date_fin.toISOString().slice(0, 10);
        const date_debu_pre = dateDebu.toISOString().slice(0, 10);
        date_fin_form.value = date_fin_pre;
        date_debu_form.value = date_debu_pre;
        console.log(date_fin_pre, date_debu_pre);
    }
});

form1.onsubmit = (e) => {
    e.preventDefault();
    const dateDebu = new Date(date_debu_form.value);
    const day = dateDebu.getDay();
    let valide = true; 
    emailHelp.innerText = "";
    select_erreur.innerText = "";
    if(base_sur_emploi.checked && tous_les_emplois.value == ""){
        select_erreur.innerText = "Vous devez choisir une date";
    }

    if (date_debu_form.value == "") {
        emailHelp.innerText = "La date de début est obligatoire !";
        valide = false; 
    } else if (day !== 1) {
        emailHelp.innerText = "Le jour doit être un lundi.";
        valide = false; 
    } else if (base_sur_emploi.checked && tous_les_emplois.value == "") { 
        valide = false;
    }
    if (valide) {
        form1.submit();
    }
};
</script>
</x-master>