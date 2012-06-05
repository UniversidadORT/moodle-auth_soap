.PHONY: clean archive

PACKAGE=auth_soap
PREFIX=soap

default: archive

clean:
	rm -f $(PACKAGE).zip

archive:
	git archive --verbose --format=zip -9 --prefix=$(PREFIX)/ HEAD > $(PACKAGE).zip

