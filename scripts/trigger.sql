CREATE OR REPLACE TRIGGER trg_add_regular_customer
AFTER INSERT ON ORDER_DETAILS
FOR EACH ROW
DECLARE
    v_customer_id ORDERS.CUSTOMER_ID%TYPE;
    v_exists NUMBER;
BEGIN
    IF :NEW.QUANTITY > 3 THEN
        SELECT CUSTOMER_ID INTO v_customer_id
        FROM ORDERS
        WHERE ORDER_ID = :NEW.ORDER_ID;
        
        SELECT COUNT(*)
        INTO v_exists
        FROM REGULAR_CUSTOMER
        WHERE CUSTOMER_ID = v_customer_id;

        IF v_exists = 0 THEN
            INSERT INTO REGULAR_CUSTOMER (CUSTOMER_ID)
            VALUES (v_customer_id);
        END IF;
    END IF;
END;
/
