// Fichier JS MARMITON



// ###### Page de formulaire ajout d'une recette
// Rajouter un champ ingrédient
$('body').on('click', '#recipeAddIngredient', function(e){
    e.preventDefault();
    var recipeIngredientQtyClass = $('.recipeIngredientQty');
    var recipeIngredientQtyCount = recipeIngredientQtyClass.length;
    recipeIngredientQtyCount = recipeIngredientQtyCount + 1;
    var recipeIngredientNameClass = $('.recipeIngredientName');
    var recipeIngredientNameCount = recipeIngredientNameClass.length;
    recipeIngredientNameCount = recipeIngredientNameCount + 1;
    var divIngredients = $('#ingredients');
    divIngredients.append('<div class="form-group"> <label class="col-md-4 control-label" for="recipeIngredientQty">Ingrédients (quantité et intitulé)</label> <div class="col-md-1"> <input name="recipeIngredientQty'+recipeIngredientQtyCount+'" type="text" placeholder="Quantité" class="recipeIngredientQty form-control input-md" required=""> </div> <div class="col-md-2"> <input name="recipeIngredientName'+recipeIngredientNameCount+'" type="text" placeholder="Ingrédient" class="recipeIngredientName form-control input-md" required=""> </div><button type="button" class="btn btn-danger removeIngredient"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Supprimer l\'ingrédient </button></div>');
});

//Supprimmer le champ ingrédient le plus proche
$('body').on('click', '.removeIngredient', function (e){
    e.preventDefault();
    var div = $(this).closest('div');
    div.remove();
});

// Rajouter un champ étape
$('body').on('click', '#recipeAddStep', function(e){
    e.preventDefault();
    var recipeStepClass = $('.recipeStep');
    var recipeStepCount = recipeStepClass.length;
    recipeStepCount = recipeStepCount + 1;
    var divEtapes = $('#etapes');
    divEtapes.append('<div class="form-group"> <label class="col-md-4 control-label" for="recipeStep">Etape de la recette</label> <div class="col-md-4"> <textarea class="form-control recipeStep" name="recipeStep'+recipeStepCount+'" required="">Décrivez votre étape de la recette.</textarea> </div><button type="button" class="btn btn-danger removeEtape"> <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> Supprimer l\'étape</button></div>');
});

//Supprimmer le champ etape le plus proche
$('body').on('click', '.removeEtape', function (e){
    e.preventDefault();
    var div = $(this).closest('div');
    div.remove();
});

