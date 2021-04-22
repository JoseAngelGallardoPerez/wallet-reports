print("Wallet Reports")

wallet_reports_options = dict(
    entrypoint = "sh /entrypoint.sh",
    dockerfile = "Dockerfile",
    port_forwards = [],
    helm_set = [],
)

docker_build(
    "velmie/wallet-reports",
    ".",
    dockerfile = wallet_reports_options["dockerfile"],
    entrypoint = wallet_reports_options["entrypoint"],
    only = [
        "./.provision",
        "./app",
        "./bootstrap",
        "./config",
        "./public",
        "./composer.json",
        "./artisan",
    ],
    live_update = [
        sync("./app", "/app/app"),
        sync("./bootstrap", "/app/bootstrap"),
        sync("./config", "/app/config"),
        sync("./public", "/app/public"),
    ],
)
k8s_resource(
    "wallet-reports",
    port_forwards = wallet_reports_options["port_forwards"],
)

yaml = helm(
    "./helm/wallet-reports",
    # The release name, equivalent to helm --name
    name = "wallet-reports",
    # The values file to substitute into the chart.
    values = ["./helm/values-dev.yaml"],
    set = wallet_reports_options["helm_set"],
)

k8s_yaml(yaml)
