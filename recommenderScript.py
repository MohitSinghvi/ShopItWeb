#!C:\Users\msing\AppData\Local\Programs\Python\Python37-32\python.exe
import sys
# import hello
# print("Hello");
# output=$output
# print(sys.executable)
# print(sys.path)
# sys.path.extend(['C:\\xampp\\htdocs\\Shopitv1\\ml-latest-small', 'C:\\Users\\msing\\AppData\\Local\\Programs\\Python\\Python37-32\\python37.zip', 'C:\\Users\\msing\\AppData\\Local\\Programs\\Python\\Python37-32\\DLLs', 'C:\\Users\\msing\\AppData\\Local\\Programs\\Python\\Python37-32\\lib', 'C:\\Users\\msing\\AppData\\Local\\Programs\\Python\\Python37-32', 'C:\\Users\\msing\\AppData\\Local\\Programs\\Python\\Python37-32\\lib\\site-packages'])
# print(sys.path)

s=sys.argv
st=" "
st=st.join(s[1:4])
# print(st)
# print(sys.path)
m=int(st)

import numpy as np
import pandas as pd

# print("HI")
data = pd.read_csv('ratings.csv')
# data.head(10)
# print("Hello")

# prod_titles_genre = pd.read_csv('prods.csv')

# # prod_titles_genre.head(10)
# data = data.merge(prod_titles_genre,on='prodId', how='left')
# data.head(10)

Average_ratings = pd.DataFrame(data.groupby('prodId')['rating'].mean())
# Average_ratings.head(10)

Average_ratings['Total Ratings'] = pd.DataFrame(data.groupby('prodId')['rating'].count())
# Average_ratings.head(10)
prod_user = data.pivot_table(index='userId',columns='prodId',values='rating')

correlations = prod_user.corrwith(prod_user[m])

recommendation = pd.DataFrame(correlations,columns=['Correlation'])
recommendation.dropna(inplace=True)
recommendation = recommendation.join(Average_ratings['Total Ratings'])
recc = recommendation[recommendation['Total Ratings']>100].sort_values('Correlation',ascending=False).reset_index()

# recc = recc.merge(prod_titles_genre,on='prodId', how='left')

print(recc.head(6))
recc.head(6).to_csv("recommendations.csv")
