// Validation errors messages for Parsley
// Load this after Parsley

Parsley.addMessages('fr', {
  defaultMessage: "Cette valeur semble non valide.",
  type: {
    email:        "Cette valeur n'est pas une adresse email valide.",
    url:          "Cette valeur n'est pas une URL valide.",
    number:       "Cette valeur doit �tre un nombre.",
    integer:      "Cette valeur doit �tre un entier.",
    digits:       "Cette valeur doit �tre num�rique.",
    alphanum:     "Cette valeur doit �tre alphanum�rique."
  },
  notblank:       "Cette valeur ne peut pas �tre vide.",
  required:       "Ce champ est requis.",
  pattern:        "Cette valeur semble non valide.",
  min:            "Cette valeur ne doit pas �tre inf�rieure � %s.",
  max:            "Cette valeur ne doit pas exc�der %s.",
  range:          "Cette valeur doit �tre comprise entre %s et %s.",
  minlength:      "Cette cha�ne est trop courte. Elle doit avoir au minimum %s caract�res.",
  maxlength:      "Cette cha�ne est trop longue. Elle doit avoir au maximum %s caract�res.",
  length:         "Cette valeur doit contenir entre %s et %s caract�res.",
  mincheck:       "Vous devez s�lectionner au moins %s choix.",
  maxcheck:       "Vous devez s�lectionner %s choix maximum.",
  check:          "Vous devez s�lectionner entre %s et %s choix.",
  equalto:        "Cette valeur devrait �tre identique."
});

Parsley.setLocale('fr');