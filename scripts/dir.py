__author__ = 'Adrian Iskra'
__date__ = '1.03.2021'

# => IMPORTS:
import sys
import os
import shutil
import glob

# => GET DATA
PATH = str(sys.argv[1])
USERNAME = str(sys.argv[2])

print(PATH)
print(USERNAME)

FULL_PATH = PATH + USERNAME
print(FULL_PATH)

# => CHECK IF USER DIR EXISTS
if os.path.isdir(FULL_PATH):

    # => IF EXISTS CHECK IF THERE ARE ANY LAST FILES
    if len(os.listdir(FULL_PATH + '/')) != 0:

        # => IF THERE ARE -> ITERATE THEM AND DELETE EACH
        files = glob.glob(FULL_PATH + '/*')
        for f in files:
            os.remove(f)

# => IF DOES NOT EXISTS -> CREATE
else:
    os.mkdir(FULL_PATH)


print('OK')
