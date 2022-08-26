-- Je veux les produits du tag id = 1
SELECT 
product.name, 
product.picture,
product.id AS id_product,
tag.id AS id_tag,
tag.name
 FROM product_has_tag
-- pour acceder à une colonne d'une table, on utilise le { . } entre le nom de la talbe et la colonne
INNER JOIN product ON product_has_tag.product_id = product.id
INNER JOIN tag ON product_has_tag.tag_id = tag.id
where tag_id = 1

-- je veux tout les tags d'un produit
SELECT 
product.id AS id_product,
product.name,
tag.id AS id_tag,
tag.name
 FROM product
INNER JOIN product_has_tag ON product.id = product_has_tag.product_id
INNER JOIN tag ON product_has_tag.tag_id = tag.id
where product.id = 4


-- Je veux les produits du tag id = 1
/* 
le mot-clé IN permet de donner une liste d'informations
généralement un ID, mais ça peut être autre chose
*/
SELECT * FROM product where id IN 
(
/* quand je fait la requete, j'obtiens une liste d'ID*/
-- exemple de liste :  1,3,4,8,11,12,13,18,20
SELECT product_id FROM product_has_tag where tag_id = 1
)

-- je veux tout les tags d'un produit
SELECT tag.*
    FROM product
INNER JOIN product_has_tag ON product.id = product_has_tag.product_id
INNER JOIN tag ON product_has_tag.tag_id = tag.id
where product.id = 1