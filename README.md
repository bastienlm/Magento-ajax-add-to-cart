# Describe
[FR]
Ajouter facilement vos produits au panier en Ajax, l'avantage de ce module comparé au autre est qu'il respecte le plus possible les bonnes pratiques magento :
- Aucun Rewrite
- Aucun Controller
- Fonctionne uniquement avec les events Magento
aucun risque de conflit avec de futur mise à jour Magento, ni avec votre développement Local !

[EN]
Easy add your product to cart in Ajax, the advantage of this module is there magento practise respect 
- No Rewrite 
- No Controller 
- Just Magento Event
No conflit with Magento update or your custom development

DEMO : https://www.screencast.com/t/dOyKIHReXq

# Requirements
[FR]
Version 1.9.x de Magento (Fonctionne probablement sur d'autres versions mais aucun test effectué pour le moment)
Thème RWD, suivre le tuto d'installation si vous utilisez un thème custom ou le base/default

[EN]
Magento 1.9.X
RWD theme, follow the install step if you use custom theme or base/default
# Install

# Getting Start
[FR]
1/ Supprimer l'action onclick="productAddToCartForm.submit(this)" du boutton Ajouter au panier de la page produit

2/ Rajouter le loader de votre choix à coté du boutton Ajouter au panier avec la class 'ph-loader'

[EN]
1/ Copy files in your Magento

2/ Delete onclick action onclick="productAddToCartForm.submit(this)" on add to cart button from the product page

3/ Add your custom loader close to add to cart button with the class 'ph-loader'


-- Principe de fonctionnement & Modification --
L'appel ajax et la manipulation du DOM ce fait dans le fichier js addtocart.js, si vous n'utilisez pas  les templates par défaut de Magento sur la fiche produit, vous devriez probablement modifier les variables

Pour modifier la structure de la popup il faut se rendre sur le template addtocart/popup.phtml

Pour utiliser cette fonction Ajax sur d'autres pages que la page produit il vous faut charger le template, le js et le css sur les pages en questions, il faut par la suite modifier les données json envoyer par la requête ajax, supprimer simplement &action_from=catalog_product_view' des données envoyées et supprimer la condition au début de la fonction returnPopupData présente dans  l'observeur

Vous n'utilisez pas le thème RWD, ou vous avez un panier structuré différemment ? Modifier le bloc charger dans la fonction _getCartHtml de l'Observeur
Si, pour office de panier, vous n'avez qu'une simple icône qui redirige sur la page panier, supprimer simplement la modification du panier en javascript


    
# Contribution
[FR]
Pour m'aider à améliorer ce module merci de me faire des pull requests uniquement sur develop

[EN]
To contribute please issue pull requests to the develop branch only.

## Installation of pre-commit hooks (origin repo)

```
cp hooks/post-commit .git/hooks/
cp hooks/pre-commit .git/hooks/

chmod 755 .git/hooks/*
```
# Copyright
Si vous utilisez ce module, merci de ne pas modifier les copyrights présent dans le code.
If you use this module, please don't modify the copyrigths, you can contribute of this module on this repo.
© PH2M & Bastien Lamamy
