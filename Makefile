gen-protobuf:
	protoc -I ./../wallet-users/rpc/proto/users/ --twirp_php_out=./rpc/users --php_out=./rpc/users users.proto
	protoc -I ./../wallet-permissions/rpc/permissions/ --twirp_php_out=./rpc/permissions --php_out=./rpc/permissions permissions.proto
docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-build:
	docker-compose up --build -d

memory:
	sudo sysctl -w vm.max_map_count=262144

perm:
	sudo chgrp -R www-data storage bootstrap/cache
	sudo chmod -R ug+rwx storage bootstrap/cache
