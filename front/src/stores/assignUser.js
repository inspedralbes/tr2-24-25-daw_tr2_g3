import { defineStore } from 'pinia';

export const useAssignUser = defineStore('users', {
  state: ()=>({
    user:[{
        id: 1,
        firstname: 'Luis',
        lastname:'Perez',
        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVHuaHBzb1_5EWWuVXAIAZwyreKC09F-0oAg&s'
      },
      {
        id: 2,
        firstname: 'Pepe',
        lastname:'Gonzalez',
        image: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRVHuaHBzb1_5EWWuVXAIAZwyreKC09F-0oAg&s'
      }
    ]

  }),
  actions:()=>({
    getUserByID(id){
      return this.user[id];
    }
  }),
});
