MKSTRAP=./bin/mkbootstrap-nurios
ENTROOT=./bin/enter-rootfs

amd64: config/config-amd64
	$(MKSTRAP) --config amd64
	$(ENTROOT) --config amd64

clean: amd64
	rm -rf amd64