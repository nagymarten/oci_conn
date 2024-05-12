CREATE OR REPLACE FUNCTION validate_user_login(p_nickname IN VARCHAR2, p_password IN VARCHAR2) RETURN VARCHAR2 IS
    v_user UGYFELEK%ROWTYPE;
BEGIN
    SELECT * INTO v_user
    FROM UGYFELEK
    WHERE NICKNAME = p_nickname;

    -- Check if the password matches (assuming password stored is hashed)
    IF v_user.PASSWORD IS NULL THEN
        RETURN 'Nickname not registered';
    ELSE
        -- Assume the password stored in the database is hashed and compare
        IF v_user.PASSWORD = DBMS_CRYPTO.HASH(UTL_RAW.CAST_TO_RAW(p_password), 3) THEN -- Using SHA-256 for example
            RETURN 'Login successful';
        ELSE
            RETURN 'Invalid password';
        END IF;
    END IF;
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        RETURN 'Nickname not registered';
    WHEN OTHERS THEN
        RETURN 'Error during login: ' || SQLERRM;
END;
