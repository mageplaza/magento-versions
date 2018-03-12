#!/bin/bash

git pull && php run.php && git add . && git commit -m "Update M2 version automatically" && git push


