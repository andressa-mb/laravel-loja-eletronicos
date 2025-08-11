 -- Comando para criar view:
 -- create view nome_view as sql...
 -- Exemplo de view
 SELECT order_product_items.id,
    order_product_items.order_id,
    order_product_items.product_id,
    order_product_items.order_quantity,
    order_product_items.order_price,
    order_product_items.order_discount_type,
    order_product_items.order_discount_value,
    order_product_items.order_total,
    order_product_items.created_at,
    order_product_items.updated_at,
    products.name AS product_name,
    orders.created_at AS order_date
   FROM order_product_items
     JOIN products ON order_product_items.product_id = products.id
     JOIN orders ON order_product_items.order_id = orders.id
  GROUP BY order_product_items.product_id, order_product_items.id, products.name, orders.created_at
  ORDER BY order_product_items.order_quantity DESC;
