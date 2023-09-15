FROM mysql:8.0
ADD init-entrypoint/* /docker-entrypoint-initdb.d/
CMD ["mysqld"]
EXPOSE 3306
