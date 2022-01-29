import React from 'react';

import { QueryClient, QueryClientProvider } from 'react-query';

import { AuthProvider } from './hooks/AuthContext';
import Router from './router';

const App: React.VFC = () => {
    const queryClient = new QueryClient({
        defaultOptions: {
            queries: {
                retry: false
            },
            mutations: {
                retry: false
            }
        }
    })

    return (
        <QueryClientProvider client={queryClient}>
           <AuthProvider>
                <div className="flex">
                    <Router />
                </div>
            </AuthProvider>
        </QueryClientProvider>
    )
}

export default App;
