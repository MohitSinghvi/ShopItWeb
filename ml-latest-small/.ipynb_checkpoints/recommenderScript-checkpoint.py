#!/usr/bin/env python
import sys
# import hello

print(sys.path)
sys.path.extend(['C:\\xampp\\htdocs\\Shopitv1\\ml-latest-small', 'C:\\Users\\msing\\Anaconda3\\python37.zip', 'C:\\Users\\msing\\Anaconda3\\DLLs', 'C:\\Users\\msing\\Anaconda3\\lib', 'C:\\Users\\msing\\Anaconda3', '', 'C:\\Users\\msing\\Anaconda3\\lib\\site-packages', 'C:\\Users\\msing\\Anaconda3\\lib\\site-packages\\win32', 'C:\\Users\\msing\\Anaconda3\\lib\\site-packages\\win32\\lib', 'C:\\Users\\msing\\Anaconda3\\lib\\site-packages\\Pythonwin', 'C:\\Users\\msing\\Anaconda3\\lib\\site-packages\\IPython\\extensions', 'C:\\Users\\msing\\.ipython', 'C:\\Users\\msing\\Anaconda3\\lib\\site-packages\\IPython\\extensions', 'C:\\Users\\msing\\.ipython', 'C:\\Users\\msing\\Anaconda3\\lib\\site-packages\\IPython\\extensions', 'C:\\Users\\msing\\.ipython', 'C:\\Users\\msing\\Anaconda3\\lib\\site-packages\\IPython\\extensions', 'C:\\Users\\msing\\.ipython', 'C:\\Users\\msing\\Anaconda3\\lib\\site-packages\\IPython\\extensions', 'C:\\Users\\msing\\.ipython', 'C:\\Users\\msing\\Anaconda3\\lib\\site-packages\\IPython\\extensions', 'C:\\Users\\msing\\.ipython'])

print(sys.path)
import numpy as np
import pandas as pd

print("Sabse pehle")
print(pd)
data = pd.read_csv('ratings.csv')
# data.head(10)
print("Sabse pehle")
movie_titles_genre = pd.read_csv("movies.csv")


print("Sabse pehle")

# movie_titles_genre.head(10)
data = data.merge(movie_titles_genre,on='movieId', how='left')
# data.head(10)

Average_ratings = pd.DataFrame(data.groupby('title')['rating'].mean())
# Average_ratings.head(10)

Average_ratings['Total Ratings'] = pd.DataFrame(data.groupby('title')['rating'].count())
# Average_ratings.head(10)
print("pehele")
movie_user = data.pivot_table(index='userId',columns='title',values='rating')

correlations = movie_user.corrwith(movie_user['Toy Story (1995)'])

recommendation = pd.DataFrame(correlations,columns=['Correlation'])
recommendation.dropna(inplace=True)
recommendation = recommendation.join(Average_ratings['Total Ratings'])
recc = recommendation[recommendation['Total Ratings']>100].sort_values('Correlation',ascending=False).reset_index()

recc = recc.merge(movie_titles_genre,on='title', how='left')
print("pehele")
print(recc.head(10))
recc.head(10).to_csv("recommendations.csv")
print("Baadmein")
