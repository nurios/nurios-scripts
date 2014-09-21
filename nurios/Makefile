MKSTRAP=./bin/mkbootstrap-nurios
ENTROOT=./bin/enter-rootfs
SQUASH=./bin/create-squashfs
ISO_MK=./bin/create-iso

amd64: config/config-amd64
	$(MKSTRAP) --config amd64
	$(ENTROOT) --config amd64
	$(SQUASH) --config amd64
	$(ISO_MK) --config amd64

clean: iso/rootfs/amd64
	rm -rf iso
