import { useState } from 'react';

const Component = () => {
  const [count, setCount] = useState(0);
  return (
    <div className='flex h-screen w-screen flex-col items-center justify-center'>
      <h1 className='text-xl font-medium'>Hello world</h1>
      <p>count state {count}</p>
      <button onClick={() => setCount((prev) => prev + 1)}>Increment</button>
    </div>
  );
};

export default Component;
