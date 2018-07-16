SELECT *
FROM [NS:Users] U
WHERE U.status = U.id > 100 ? "Y" :"N"