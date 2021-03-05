#!interpreter D:\Python\python.exe

# -*- coding: utf-8 -*-

"""
Description: python script that calculates the win-rate of user

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
CHART_NAME = 'winrate-' + str(int(time.time())) + '.jpg'

# => GET CHART SAVE PATH
SAVE_PATH = str(sys.argv[1])

USER = str(sys.argv[2])
AI = str(sys.argv[3])

USER = func.extract_from_dots(USER)
AI = func.extract_from_dots(AI)

WINS = 0
ALL = len(USER)

for user, ai in zip(USER, AI):
    if user > ai:
        WINS += 1

DATA = [WINS, ALL-WINS]
labels = ['WON - ' + str(int(((WINS / ALL) * 100))) + '%', 'LOST - ' + str(int((((ALL-WINS) / ALL) * 100))) + '%']

data = np.array(DATA)


# => USE PIE CHART TO VISUALIZE DATA
plt.pie(data, labels=labels, explode=func.explode[:2], shadow=True)
plt.legend(labels=['Won', 'Lost'], loc="best", bbox_to_anchor=(0.5, 0., 0.8, 1))
plt.title('WIN RATE')


try:
    # => SAVE CHART TO FILE
    plt.savefig(SAVE_PATH + CHART_NAME)

except NotADirectoryError:
    print('[-] ERROR | Given directory name is not a dir! ')

print(SAVE_PATH + CHART_NAME)
