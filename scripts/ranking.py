#!interpreter D:\Python\python.exe

# -*- coding: utf-8 -*-

"""
Description: python script that calculates the position of each player in ranking

"""

__author__ = 'Adrian Iskra'
__date__ = '1.03.2021'

# => IMPORTS:
import sys

# => LIB IMPORTS:
import func

# => GET DATA
ID = str(sys.argv[1])
USER = str(sys.argv[2])
AI = str(sys.argv[3])
LEVELS = str(sys.argv[4])

ID = func.extract_from_dots(ID)
USER = func.extract_from_dots(USER)
AI = func.extract_from_dots(AI)
LEVELS = LEVELS.split('.')

data = {key: [] for key in ID}

# => DELETE ID DUPLICATES
for user, index in enumerate(ID):
    for userID, s, ai, level in zip(ID, USER, AI, LEVELS):
        if userID == user:
            data[user].append([s, ai, level])


users = {key: 0 for key in ID}
ID = set(ID)


for user, element in zip(ID, data.values()):
    for e in element:
        if e[0] > e[1]:
            users[user] += func.points[e[2]]

users = sorted(users.items(), key=lambda x: x[1], reverse=True)

new = {}
result = ''

for user in users:
    new[user[0]] = user[1]

result = ''.join('{}.'.format(int(k), int(v)) for k, v in new.items())
result = result[:-1]

print(result)



