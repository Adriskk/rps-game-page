#!interpreter D:\Python\python.exe

# -*- coding: utf-8 -*-

"""
Description: python script that creates a chart from given data

"""

__author__ = 'Adrian Iskra'
__date__ = '1.03.2021'

# => IMPORTS:
import sys
import time

# => LIB IMPORTS:
import func

# => 3-RD PARTY IMPORTS:
import matplotlib.pyplot as plt
import numpy as np

# => CHART NAME IS A CURRENT TIMESTAMP
CHART_NAME = 'levels-' + str(int(time.time())) + '.jpg'

# => GET CHART SAVE PATH
SAVE_PATH = str(sys.argv[1])

# => GET DATA AND COMPRESS
DATA = str(sys.argv[2])
DATA = func.extract_from_args(DATA)


data = np.array(DATA)

ALL = sum(data)
AMATEUR = data[0]
INTER = data[1]
EXPERT = data[2]
labels = [
    'Amateur - ' + str(int((AMATEUR/ALL)*100)) + '%',
    'Intermediate - ' + str(int((INTER/ALL)*100)) + '%',
    'Expert - ' + str(int((EXPERT/ALL)*100)) + '%'
]


# => USE PIE CHART TO VISUALIZE DATA
plt.pie(data, labels=labels, explode=func.explode, shadow=True)
plt.legend(labels=['Amateur', 'Intermediate', 'Expert'], loc="best", bbox_to_anchor=(0.5, 0., 0.8, 1))
plt.title('TOTAL GAMES PLAYED')


try:
    # => SAVE CHART TO FILE
    plt.savefig(SAVE_PATH + CHART_NAME)

except NotADirectoryError:
    print('[-] ERROR | Given directory name is not a dir! ')

print(SAVE_PATH + CHART_NAME)

