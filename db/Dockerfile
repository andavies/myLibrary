FROM mysql:5.7

ENV MYSQL_ROOT_PASSWORD YOURPASSWORDHERE
ENV MYSQL_DATABASE db_project

# Add the content of the initialisation-scripts/ directory to your image
# All scripts in docker-entrypoint-initdb.d/ are automatically
# executed during container startup
COPY ./create-tables.sql /docker-entrypoint-initdb.d/