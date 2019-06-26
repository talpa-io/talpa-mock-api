FROM infracamp/kickstart-flavor-gaia

ENV DEV_CONTAINER_NAME="talpa-mock-api"

ADD / /opt
RUN ["bash", "-c",  "chown -R user /opt"]
RUN ["/kickstart/flavorkit/scripts/start.sh", "build"]

ENTRYPOINT ["/kickstart/flavorkit/scripts/start.sh", "standalone"]
