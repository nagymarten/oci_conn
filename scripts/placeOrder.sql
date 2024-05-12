CREATE OR REPLACE PROCEDURE placeOrder(customerId IN NUMBER, orders IN CLOB) IS
  v_order_id ORDERS.ORDER_ID%TYPE;
BEGIN
  -- Insert a new order and retrieve the ORDER_ID
  INSERT INTO ORDERS (CUSTOMER_ID, ORDER_DATE)
  VALUES (customerId, SYSDATE)
  RETURNING ORDER_ID INTO v_order_id;
  
  -- Assuming 'orders' is a JSON array of objects formatted as:
  -- [{"isbn":"978-1-60309-057-5","quantity":10,"price":150.00}, ...]
  -- You'll need to parse this JSON in Oracle 12c and later using JSON_TABLE

  -- Loop through the JSON array to insert details into ORDER_DETAILS
  FOR rec IN (
    SELECT j.isbn, j.quantity, j.price
    FROM JSON_TABLE(orders, '$[*]'
      COLUMNS (
        isbn VARCHAR2(20) PATH '$.isbn',
        quantity NUMBER PATH '$.quantity',
        price NUMBER PATH '$.price'
      )
    ) j
  ) LOOP
    INSERT INTO ORDER_DETAILS (ORDER_ID, ISBN, QUANTITY, PRICE)
    VALUES (v_order_id, rec.isbn, rec.quantity, rec.price);
  END LOOP;

  -- Commit the transaction
  COMMIT;
EXCEPTION
  WHEN OTHERS THEN
    -- Handle exceptions
    ROLLBACK;
    RAISE;
END placeOrder;